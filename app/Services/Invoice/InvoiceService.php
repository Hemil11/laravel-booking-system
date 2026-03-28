<?php

namespace App\Services\Invoice;

use App\Models\Booking;
use App\Models\Invoice;

class InvoiceService
{
    public const DEFAULT_TAX_RATE = 0.10;

    /**
     * Create an invoice when a booking is created, or refresh line amounts from the linked service
     * while the invoice is still unpaid.
     */
    public function syncForBooking(Booking $booking): Invoice
    {
        $booking->loadMissing('service');

        $amount = (float) ($booking->service?->price ?? 0);
        $tax = round($amount * self::DEFAULT_TAX_RATE, 2);
        $total = round($amount + $tax, 2);

        /** @var Invoice $invoice */
        $invoice = Invoice::query()->firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $amount,
                'tax' => $tax,
                'total' => $total,
                'status' => Invoice::STATUS_UNPAID,
            ]
        );

        if (! $invoice->wasRecentlyCreated && $invoice->status !== Invoice::STATUS_PAID) {
            $invoice->update([
                'amount' => $amount,
                'tax' => $tax,
                'total' => $total,
            ]);
        }

        return $invoice->fresh();
    }
}
