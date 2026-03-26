<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BookingConflictException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Staff;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function store(StoreBookingRequest $request): JsonResponse
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
            return ApiResponse::error($e->getMessage(), null, 409);
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        $booking->load(['staff', 'service']);

        return ApiResponse::success(
            ['booking' => $this->bookingPayload($booking)],
            __('Booking created.'),
            201
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function bookingPayload(Booking $booking): array
    {
        return [
            'id' => $booking->id,
            'user_id' => $booking->user_id,
            'staff_id' => $booking->staff_id,
            'service_id' => $booking->service_id,
            'date' => $booking->date->toDateString(),
            'time' => $booking->time,
            'status' => $booking->status,
            'notes' => $booking->notes,
            'staff' => $booking->staff ? [
                'id' => $booking->staff->id,
                'full_name' => $booking->staff->full_name,
            ] : null,
            'service' => $booking->service ? [
                'id' => $booking->service->id,
                'name' => $booking->service->name,
                'duration' => $booking->service->duration,
            ] : null,
        ];
    }
}
