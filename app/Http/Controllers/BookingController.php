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
use Illuminate\View\View;
use InvalidArgumentException;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function index(): View
    {
        $bookings = request()->user()
            ->bookings()
            ->with(['staff', 'service'])
            ->latest()
            ->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        return view('bookings.create', [
            'staffMembers' => Staff::query()->where('is_active', true)->orderBy('full_name')->get(),
            'services' => Service::query()->orderBy('name')->get(),
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
                $request->validated('status', 'pending'),
                $request->validated('notes')
            );
        } catch (BookingConflictException $e) {
            return back()->withErrors(['time' => $e->getMessage()])->withInput();
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['booking' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Booking created.'));
    }

    public function show(Booking $booking): View
    {
        $this->ensureOwnsBooking($booking);
        $booking->load(['staff', 'service', 'slots']);

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
        $this->ensureOwnsBooking($booking);

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
        $this->ensureOwnsBooking($booking);

        try {
            $this->bookingService->confirmBooking($booking);
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['booking' => $e->getMessage()]);
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Booking confirmed.'));
    }

    protected function ensureOwnsBooking(Booking $booking): void
    {
        if ($booking->user_id !== request()->user()?->id) {
            abort(403);
        }
    }
}
