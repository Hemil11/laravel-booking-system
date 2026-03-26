<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AvailableSlotsRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Service;
use App\Models\Staff;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class AvailableSlotController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function __invoke(AvailableSlotsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $staff = Staff::query()->findOrFail($data['staff_id']);
        $service = Service::query()->findOrFail($data['service_id']);

        try {
            $slots = $this->bookingService->getAvailableSlots($staff, $service, $data['date']);
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        return ApiResponse::success(['slots' => $slots]);
    }
}
