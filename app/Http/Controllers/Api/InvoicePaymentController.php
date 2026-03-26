<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessMockPaymentRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Invoice;
use App\Services\Payment\MockPaymentService;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class InvoicePaymentController extends Controller
{
    public function __construct(
        protected MockPaymentService $mockPaymentService
    ) {}

    public function process(ProcessMockPaymentRequest $request, Invoice $invoice): JsonResponse
    {
        $invoice->loadMissing('booking');
        $booking = $invoice->booking;

        if (! $booking) {
            return ApiResponse::error('Invoice is not linked to a booking.', null, 404);
        }

        $user = $request->user();
        $canManage = $user?->hasPermission('manage_bookings') ?? false;
        if ($booking->user_id !== $user?->id && ! $canManage) {
            return ApiResponse::error('Forbidden.', null, 403);
        }

        try {
            $processed = $this->mockPaymentService->process($invoice, $request->validated('result'));
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), null, 422);
        }

        return ApiResponse::success([
            'invoice' => [
                'id' => $processed->id,
                'booking_id' => $processed->booking_id,
                'amount' => $processed->amount,
                'tax' => $processed->tax,
                'total' => $processed->total,
                'status' => $processed->status,
            ],
            'booking' => [
                'id' => $processed->booking?->id,
                'status' => $processed->booking?->status,
            ],
        ], __('Mock payment processed.'));
    }
}
