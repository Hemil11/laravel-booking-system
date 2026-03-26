<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'users' => User::query()->count(),
            'bookings' => Booking::query()->count(),
            'services' => Service::query()->count(),
            'todays_bookings' => Booking::query()
                ->whereDate('date', now()->toDateString())
                ->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
