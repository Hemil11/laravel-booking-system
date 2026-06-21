<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id || $user->hasPermission('manage_bookings');
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id || $user->hasPermission('manage_bookings');
    }

    public function confirm(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id || $user->hasPermission('manage_bookings');
    }

    public function updateStatus(User $user, Booking $booking): bool
    {
        return $user->hasPermission('manage_bookings');
    }
}
