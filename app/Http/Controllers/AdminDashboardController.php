<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

/**
 * Example: this route is registered with middleware `permission:manage_users` in `routes/web.php`.
 * That grants access only to users whose roles include the `manage_users` permission.
 */
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
