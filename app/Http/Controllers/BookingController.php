<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingConflictException;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Staff;
use App\Services\Booking\BookingService;
use App\Support\PerformanceCache;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', Rule::in(['', 'pending', 'confirmed', 'completed', 'cancelled'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $statusFilter = ($validated['status'] ?? '') !== '' ? $validated['status'] : null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $bookingsQuery = $user->hasPermission('manage_bookings')
            ? Booking::query()
            : $user->bookings();

        $bookings = $bookingsQuery
            ->with(['staff', 'service', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('bookings.status', 'like', '%'.$search.'%')
                        ->orWhereHas('staff', function ($staffQuery) use ($search) {
                            $staffQuery->where('full_name', 'like', '%'.$search.'%');
                        })
                        ->orWhereHas('service', function ($serviceQuery) use ($search) {
                            $serviceQuery->where('name', 'like', '%'.$search.'%');
                        })
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                        });
                    $bookingId = filter_var($search, FILTER_VALIDATE_INT);
                    if ($bookingId !== false) {
                        $inner->orWhere('bookings.id', $bookingId);
                    }
                });
            })
            ->when(filled($statusFilter), fn ($query) => $query->where('status', $statusFilter))
            ->when($dateFrom, fn ($query) => $query->whereDate('date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('date', '<=', $dateTo))
            ->orderByDesc('date')
            ->orderBy('time')
            ->paginate(15)
            ->withQueryString();

        $filters = [
            'search' => $search,
            'status' => $statusFilter,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];

        $statusOptions = [
            'pending' => __('Pending'),
            'confirmed' => __('Confirmed'),
            'completed' => __('Completed'),
            'cancelled' => __('Cancelled'),
        ];

        $bulkStatusOptions = [
            'pending' => __('Mark as pending'),
            'confirmed' => __('Mark as confirmed'),
            'completed' => __('Mark as completed'),
            'cancelled' => __('Mark as cancelled'),
        ];

        return view('bookings.index', compact('bookings', 'filters', 'statusOptions', 'bulkStatusOptions'));
    }

    public function calendar(Request $request): View
    {
        $user = $request->user();

        if (! $request->filled('staff_id')) {
            $request->merge(['staff_id' => null]);
        }

        $validated = $request->validate([
            'view' => ['nullable', 'string', Rule::in(['day', 'week'])],
            'date' => ['nullable', 'date'],
            'staff_id' => ['nullable', 'integer', 'exists:staffs,id'],
        ]);

        $viewMode = $validated['view'] ?? 'week';
        $anchor = isset($validated['date'])
            ? Carbon::parse($validated['date'])->startOfDay()
            : Carbon::today();

        $staffId = isset($validated['staff_id']) ? (int) $validated['staff_id'] : null;
        $selectedStaff = null;
        if ($staffId !== null) {
            $selectedStaff = Staff::query()->whereKey($staffId)->whereNull('deleted_at')->first();
            if (! $selectedStaff || ! $selectedStaff->is_active) {
                $staffId = null;
                $selectedStaff = null;
            }
        }

        $weekStart = $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $days = $viewMode === 'day'
            ? collect([$anchor->copy()])
            : collect(range(0, 6))->map(fn (int $i) => $weekStart->copy()->addDays($i));

        $rangeStart = $days->first()->toDateString();
        $rangeEnd = $days->last()->toDateString();

        $bookingsQuery = $user->hasPermission('manage_bookings')
            ? Booking::query()
            : $user->bookings();

        $bookings = $bookingsQuery
            ->with(['staff', 'service', 'user'])
            ->whereDate('date', '>=', $rangeStart)
            ->whereDate('date', '<=', $rangeEnd)
            ->where('status', '!=', 'cancelled')
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        /** @var Collection<string, Collection<int, Booking>> $bookingsByDate */
        $bookingsByDate = $bookings->groupBy(fn (Booking $b) => $b->date->format('Y-m-d'));

        $activeStaff = Staff::query()->where('is_active', true)->whereNull('deleted_at')->orderBy('full_name')->get();
        [$gridStartMin, $gridEndMin] = $this->calendarGridMinutes($activeStaff, $selectedStaff);

        if ($gridEndMin <= $gridStartMin) {
            $gridStartMin = 8 * 60;
            $gridEndMin = 18 * 60;
        }

        $slotStep = BookingService::SLOT_STEP_MINUTES;
        $totalMinutes = $gridEndMin - $gridStartMin;
        $slotRows = intdiv($totalMinutes, $slotStep);
        $slotPx = 28;
        $calendarHeight = $slotRows * $slotPx;

        $timeLabels = [];
        for ($m = $gridStartMin; $m < $gridEndMin; $m += $slotStep) {
            $rel = $m - $gridStartMin;
            $topPx = ($rel / $totalMinutes) * $calendarHeight;
            $h = intdiv($m, 60);
            $min = $m % 60;
            $timeLabels[] = [
                'topPx' => $topPx,
                'label' => Carbon::createFromTime($h, $min, 0)->format('g:i A'),
            ];
        }

        $dayMetas = $days->map(function (Carbon $d) use (
            $bookingsByDate,
            $gridStartMin,
            $gridEndMin,
            $totalMinutes,
            $calendarHeight,
            $staffId,
            $selectedStaff,
            $slotStep,
        ) {
            $ymd = $d->format('Y-m-d');
            $dayBookings = $bookingsByDate->get($ymd, collect());
            if ($staffId !== null) {
                $dayBookings = $dayBookings->where('staff_id', $staffId)->values();
            }

            $occupiedSet = [];
            if ($staffId !== null && $selectedStaff) {
                foreach ($this->bookingService->occupiedSlotTimesForStaff($staffId, $ymd) as $t) {
                    $occupiedSet[$t] = true;
                }
            }

            $blocks = $this->calendarBookingBlocks(
                $dayBookings,
                $gridStartMin,
                $gridEndMin,
                $calendarHeight,
                $totalMinutes
            );

            $clickableSlots = collect();
            if ($staffId !== null && $selectedStaff) {
                $clickableSlots = $this->calendarClickableSlots(
                    $d,
                    $selectedStaff,
                    $gridStartMin,
                    $gridEndMin,
                    $totalMinutes,
                    $calendarHeight,
                    $slotStep,
                    $occupiedSet,
                    $staffId
                );
            }

            return [
                'date' => $d,
                'ymd' => $ymd,
                'label' => $d->format('D'),
                'subLabel' => $d->format('M j'),
                'isToday' => $d->isToday(),
                'blocks' => $blocks,
                'clickableSlots' => $clickableSlots,
            ];
        });

        $staffOptions = $activeStaff->pluck('full_name', 'id')->all();

        $queryBase = array_filter([
            'view' => $viewMode,
            'staff_id' => $staffId,
        ], fn ($v) => $v !== null && $v !== '');

        $prevDate = $viewMode === 'week'
            ? $weekStart->copy()->subWeek()->toDateString()
            : $anchor->copy()->subDay()->toDateString();
        $nextDate = $viewMode === 'week'
            ? $weekStart->copy()->addWeek()->toDateString()
            : $anchor->copy()->addDay()->toDateString();

        $navUrls = [
            'prev' => route('bookings.calendar', array_merge($queryBase, ['date' => $prevDate])),
            'next' => route('bookings.calendar', array_merge($queryBase, ['date' => $nextDate])),
            'today' => route('bookings.calendar', array_merge($queryBase, ['date' => Carbon::today()->toDateString()])),
            'day' => route('bookings.calendar', array_merge($queryBase, ['view' => 'day', 'date' => $anchor->toDateString()])),
            'week' => route('bookings.calendar', array_merge($queryBase, ['view' => 'week', 'date' => $anchor->toDateString()])),
        ];

        return view('bookings.calendar', [
            'viewMode' => $viewMode,
            'anchor' => $anchor,
            'weekStart' => $weekStart,
            'staffId' => $staffId,
            'selectedStaff' => $selectedStaff,
            'dayMetas' => $dayMetas,
            'staffOptions' => $staffOptions,
            'gridStartMin' => $gridStartMin,
            'gridEndMin' => $gridEndMin,
            'slotPx' => $slotPx,
            'calendarHeight' => $calendarHeight,
            'totalMinutes' => $totalMinutes,
            'slotStep' => $slotStep,
            'timeLabels' => $timeLabels,
            'navUrls' => $navUrls,
            'queryBase' => $queryBase,
        ]);
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bulk_action' => ['required', 'string', Rule::in(['delete', 'set_status'])],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'status_value' => ['nullable', 'string', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);

        $ids = array_values(array_unique(array_map('intval', $validated['ids'])));
        $bookings = Booking::query()->whereIn('id', $ids)->get();

        if ($bookings->count() !== count($ids)) {
            return back()->withErrors(['ids' => __('Invalid selection.')]);
        }

        foreach ($bookings as $booking) {
            Gate::authorize('view', $booking);
        }

        $affected = 0;

        if ($validated['bulk_action'] === 'delete') {
            foreach ($bookings as $booking) {
                Gate::authorize('cancel', $booking);
                if ($booking->status !== 'cancelled') {
                    $this->bookingService->cancelBooking($booking);
                    $affected++;
                }
            }

            return back()->with('status', __('Cancelled :n booking(s).', ['n' => $affected]));
        }

        $statusValue = $validated['status_value'] ?? '';
        if ($statusValue === '') {
            return back()->withErrors(['status_value' => __('Choose a status to apply.')]);
        }

        if ($statusValue === 'completed' && ! $request->user()->hasPermission('manage_bookings')) {
            return back()->withErrors(['status_value' => __('You cannot apply this status.')]);
        }

        if ($request->user()->hasPermission('manage_bookings')) {
            foreach ($bookings as $booking) {
                Gate::authorize('view', $booking);
                try {
                    $before = $booking->fresh()->status;
                    $updated = $this->bookingService->applyAdminStatus($booking->fresh(), $statusValue);
                    if ($updated->status !== $before) {
                        $affected++;
                    }
                } catch (InvalidArgumentException|BookingConflictException $e) {
                    continue;
                }
            }

            return back()->with('status', __('Updated :n booking(s).', ['n' => $affected]));
        }

        foreach ($bookings as $booking) {
            if ($statusValue === 'cancelled') {
                Gate::authorize('cancel', $booking);
                if ($booking->status !== 'cancelled') {
                    $this->bookingService->cancelBooking($booking);
                    $affected++;
                }

                continue;
            }

            if ($statusValue === 'confirmed') {
                Gate::authorize('confirm', $booking);
                if ($booking->status === 'cancelled') {
                    continue;
                }
                try {
                    $before = $booking->status;
                    $this->bookingService->confirmBooking($booking);
                    if ($before !== 'confirmed') {
                        $affected++;
                    }
                } catch (InvalidArgumentException) {
                    continue;
                }

                continue;
            }

            if ($statusValue === 'pending') {
                if ($booking->status === 'cancelled' || $booking->status === 'pending') {
                    continue;
                }
                DB::transaction(function () use ($booking): void {
                    $booking->invoice()?->delete();
                    $booking->update(['status' => 'pending']);
                });
                $affected++;
            }
        }

        return back()->with('status', __('Updated :n booking(s).', ['n' => $affected]));
    }

    public function create(): View
    {
        $staffMembers = Cache::remember(
            PerformanceCache::BOOKING_FORM_STAFF,
            config('performance.booking_form_ttl'),
            static fn () => Staff::query()
                ->where('is_active', true)
                ->orderBy('full_name')
                ->select(['id', 'full_name'])
                ->get()
        );

        $services = Cache::remember(
            PerformanceCache::BOOKING_FORM_SERVICES,
            config('performance.booking_form_ttl'),
            static fn () => Service::query()
                ->orderBy('name')
                ->select(['id', 'name', 'duration'])
                ->get()
        );

        return view('bookings.create', [
            'staffMembers' => $staffMembers,
            'services' => $services,
            'staffOptions' => $staffMembers->pluck('full_name', 'id')->all(),
            'serviceOptions' => $services->mapWithKeys(fn ($svc) => [$svc->id => $svc->name.' ('.$svc->duration.' min)'])->all(),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $staff = Staff::query()->findOrFail($request->validated('staff_id'));
        $service = Service::query()->findOrFail($request->validated('service_id'));

        try {
            $booking = $this->bookingService->createBooking(
                $request->user(),
                $staff,
                $service,
                $request->validated('date'),
                $request->validated('time'),
                'pending',
                $request->validated('notes')
            );
        } catch (BookingConflictException $e) {
            return back()->withErrors(['time' => $e->getMessage()])->withInput();
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['booking' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Booking created successfully.'));
    }

    public function show(Booking $booking): View
    {
        Gate::authorize('view', $booking);
        $booking->load(['staff', 'service', 'slots', 'invoice']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * JSON list of available start times for the given staff, service, and date.
     */
    public function availableSlots(Request $request): JsonResponse
    {
        $data = $request->validate([
            'staff_id' => ['required', 'integer', 'exists:staffs,id'],
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $staff = Staff::query()
            ->select(['id', 'start_time', 'end_time', 'is_active'])
            ->findOrFail($data['staff_id']);
        $service = Service::query()
            ->select(['id', 'duration'])
            ->findOrFail($data['service_id']);

        try {
            $slots = $this->bookingService->getAvailableSlots($staff, $service, $data['date']);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage(), 'slots' => []], 422);
        }

        return response()->json(['slots' => $slots]);
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        Gate::authorize('cancel', $booking);

        if ($booking->status === 'cancelled') {
            return back()->with('status', __('Already cancelled.'));
        }

        $this->bookingService->cancelBooking($booking);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Booking cancelled.'));
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        Gate::authorize('confirm', $booking);

        try {
            $this->bookingService->confirmBooking($booking);
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['booking' => $e->getMessage()]);
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Booking confirmed.'));
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        Gate::authorize('updateStatus', $booking);

        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);

        try {
            $this->bookingService->applyAdminStatus($booking, $data['status']);
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['status' => $e->getMessage()]);
        } catch (BookingConflictException $e) {
            return back()->withErrors(['status' => $e->getMessage()]);
        }

        return back()->with('status', __('Booking status updated.'));
    }

    /**
     * @return array{0: int, 1: int} Start and end minutes from midnight for the grid.
     */
    protected function calendarGridMinutes(Collection $activeStaff, ?Staff $selectedStaff): array
    {
        if ($selectedStaff && $selectedStaff->is_active) {
            $day = Carbon::today();
            $start = $day->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $selectedStaff->start_time));
            $end = $day->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $selectedStaff->end_time));

            return [$this->minutesSinceMidnight($start), $this->minutesSinceMidnight($end)];
        }

        if ($activeStaff->isEmpty()) {
            return [8 * 60, 18 * 60];
        }

        $starts = $activeStaff->map(function (Staff $s) {
            $day = Carbon::today();

            return $this->minutesSinceMidnight($day->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $s->start_time)));
        });
        $ends = $activeStaff->map(function (Staff $s) {
            $day = Carbon::today();

            return $this->minutesSinceMidnight($day->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $s->end_time)));
        });

        return [$starts->min(), $ends->max()];
    }

    protected function normalizeCalendarTime(string $time): string
    {
        $time = trim($time);

        return strlen($time) === 5 ? $time.':00' : $time;
    }

    protected function minutesSinceMidnight(Carbon $dt): int
    {
        return ($dt->hour * 60) + $dt->minute;
    }

    /**
     * @param  Collection<int, Booking>  $dayBookings
     * @return Collection<int, array<string, mixed>>
     */
    protected function calendarBookingBlocks(
        Collection $dayBookings,
        int $gridStartMin,
        int $gridEndMin,
        float $calendarHeight,
        int $totalMinutes,
    ): Collection {
        $raw = [];
        foreach ($dayBookings as $booking) {
            $service = $booking->service;
            if (! $service) {
                continue;
            }
            $duration = (int) $service->duration;
            $day = Carbon::parse($booking->date->format('Y-m-d'))->startOfDay();
            $start = $day->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $booking->time));
            $startMin = $this->minutesSinceMidnight($start);
            $endMin = $startMin + $duration;
            $clipStart = max($startMin, $gridStartMin);
            $clipEnd = min($endMin, $gridEndMin);
            if ($clipStart >= $clipEnd) {
                continue;
            }
            $top = (($clipStart - $gridStartMin) / $totalMinutes) * $calendarHeight;
            $height = (($clipEnd - $clipStart) / $totalMinutes) * $calendarHeight;
            $raw[] = [
                'booking' => $booking,
                'startMin' => $clipStart,
                'endMin' => $clipEnd,
                'top' => $top,
                'height' => max($height, 20),
                'lane' => 0,
                'laneCount' => 1,
            ];
        }

        if ($raw === []) {
            return collect();
        }

        usort($raw, fn (array $a, array $b) => $a['startMin'] <=> $b['startMin']);

        $laneEnds = [];
        $maxLanes = 1;
        foreach ($raw as $i => $block) {
            $lane = 0;
            while (isset($laneEnds[$lane]) && $laneEnds[$lane] > $block['startMin']) {
                $lane++;
            }
            $raw[$i]['lane'] = $lane;
            $laneEnds[$lane] = $block['endMin'];
            $maxLanes = max($maxLanes, $lane + 1);
        }

        foreach ($raw as $i => $block) {
            $raw[$i]['laneCount'] = $maxLanes;
        }

        return collect($raw)->map(function (array $block) {
            $n = $block['laneCount'];
            $gap = $n > 1 ? 1.5 : 0;
            $width = $n > 1 ? (100 / $n) - $gap : 100;
            $left = $n > 1 ? (($block['lane'] / $n) * 100) + ($gap / 2) : 0;

            $block['leftPct'] = $left;
            $block['widthPct'] = max($width, 15);

            return $block;
        });
    }

    /**
     * @param  array<string, true>  $occupiedSet
     * @return Collection<int, array<string, mixed>>
     */
    protected function calendarClickableSlots(
        Carbon $day,
        Staff $staff,
        int $gridStartMin,
        int $gridEndMin,
        int $totalMinutes,
        float $calendarHeight,
        int $slotStep,
        array $occupiedSet,
        int $staffId,
    ): Collection {
        $dayStart = $day->copy()->startOfDay();
        $staffWorkStart = $dayStart->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $staff->start_time));
        $staffWorkEnd = $dayStart->copy()->setTimeFromTimeString($this->normalizeCalendarTime((string) $staff->end_time));
        $workStartMin = $this->minutesSinceMidnight($staffWorkStart);
        $workEndMin = $this->minutesSinceMidnight($staffWorkEnd);

        $now = Carbon::now();
        $out = [];

        for ($m = $gridStartMin; $m < $gridEndMin; $m += $slotStep) {
            if ($m < $workStartMin || ($m + $slotStep) > $workEndMin) {
                continue;
            }

            $h = intdiv($m, 60);
            $min = $m % 60;
            $timeStr = sprintf('%02d:%02d:00', $h, $min);

            if (isset($occupiedSet[$timeStr])) {
                continue;
            }

            $slotStart = $dayStart->copy()->setTime($h, $min, 0);
            if ($slotStart->lt($now)) {
                continue;
            }

            $rel = $m - $gridStartMin;
            $topPx = ($rel / $totalMinutes) * $calendarHeight;
            $heightPx = ($slotStep / $totalMinutes) * $calendarHeight;

            $out[] = [
                'topPx' => $topPx,
                'heightPx' => max($heightPx, 16),
                'href' => route('bookings.create', [
                    'date' => $day->toDateString(),
                    'time' => sprintf('%02d:%02d', $h, $min),
                    'staff_id' => $staffId,
                ]),
            ];
        }

        return collect($out);
    }
}
