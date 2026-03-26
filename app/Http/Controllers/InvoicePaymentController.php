<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessMockPaymentRequest;
use App\Models\Invoice;
use App\Services\Payment\MockPaymentService;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

class InvoicePaymentController extends Controller
{
    public function __construct(
        protected MockPaymentService $mockPaymentService
    ) {}

    public function process(ProcessMockPaymentRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->loadMissing('booking');
        $booking = $invoice->booking;

        if (! $booking) {
            abort(404);
        }

        $user = $request->user();
        $canManage = $user?->hasPermission('manage_bookings') ?? false;
        if ($booking->user_id !== $user?->id && ! $canManage) {
            abort(403);
        }

        try {
            $processed = $this->mockPaymentService->process($invoice, $request->validated('result'));
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', __('Mock payment processed: :status.', ['status' => $processed->status]));
    }
}
