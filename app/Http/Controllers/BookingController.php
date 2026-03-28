<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingConflictException;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Staff;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'status' => ['nullable', 'string', Rule::in(['', 'pending', 'confirmed', 'cancelled'])],
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
                    $inner->where('status', 'like', '%'.$search.'%')
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
            'cancelled' => __('Cancelled'),
        ];

        $bulkStatusOptions = [
            'pending' => __('Mark as pending'),
            'confirmed' => __('Mark as confirmed'),
            'cancelled' => __('Mark as cancelled'),
        ];

        return view('bookings.index', compact('bookings', 'filters', 'statusOptions', 'bulkStatusOptions'));
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bulk_action' => ['required', 'string', Rule::in(['delete', 'set_status'])],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'status_value' => ['nullable', 'string', Rule::in(['pending', 'confirmed', 'cancelled'])],
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
        $staffMembers = Staff::query()->where('is_active', true)->orderBy('full_name')->get();
        $services = Service::query()->orderBy('name')->get();

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

        $staff = Staff::query()->findOrFail($data['staff_id']);
        $service = Service::query()->findOrFail($data['service_id']);

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
}
