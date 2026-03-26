<?php

namespace App\Services\Payment;

use App\Models\Invoice;
use App\Notifications\BookingStatusChangedNotification;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MockPaymentService
{
    public function process(Invoice $invoice, string $result): Invoice
    {
        if (! in_array($result, ['success', 'failure'], true)) {
            throw new InvalidArgumentException('Payment result must be success or failure.');
        }

        $invoice->loadMissing('booking');
        $booking = $invoice->booking;

        if (! $booking) {
            throw new InvalidArgumentException('Invoice is not linked to a booking.');
        }

        if ($booking->status === 'cancelled') {
            throw new InvalidArgumentException('Cannot process payment for a cancelled booking.');
        }

        return DB::transaction(function () use ($invoice, $booking, $result) {
            $fromStatus = (string) $booking->status;

            if ($result === 'success') {
                $invoice->update(['status' => 'paid']);
                $booking->update(['status' => 'confirmed']);
            } else {
                $invoice->update(['status' => 'unpaid']);
                $booking->update(['status' => 'pending']);
            }

            $updated = $invoice->fresh(['booking.user']);
            $toStatus = (string) ($updated->booking?->status ?? $fromStatus);

            if ($toStatus !== $fromStatus && $updated->booking?->user) {
                DB::afterCommit(function () use ($updated, $fromStatus, $toStatus): void {
                    $updated->booking?->user?->notify(
                        new BookingStatusChangedNotification($updated->booking, $fromStatus, $toStatus)
                    );
                });
            }

            return $updated;
        });
    }
}
