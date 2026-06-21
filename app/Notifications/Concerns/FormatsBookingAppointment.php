<?php

namespace App\Notifications\Concerns;

use App\Models\Booking;
use Carbon\Carbon;

trait FormatsBookingAppointment
{
    protected function bookingAppointmentLabel(Booking $booking): string
    {
        $date = $booking->date->toDateString();
        $time = (string) $booking->time;

        return Carbon::parse($date.' '.$time)
            ->timezone(config('app.timezone'))
            ->format('l, F j, Y g:i A');
    }
}
