<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function processPayment(User $user, Invoice $invoice): bool
    {
        $invoice->loadMissing('booking');
        $booking = $invoice->booking;

        if (! $booking) {
            return false;
        }

        return $booking->user_id === $user->id || $user->hasPermission('manage_bookings');
    }
}
