<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
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
        $totalBookings = Booking::query()->count();
        $revenuePaid = (float) Invoice::query()->where('status', 'paid')->sum('total');

        $stats = [
            'users' => User::query()->count(),
            'bookings' => $totalBookings,
            'services' => Service::query()->count(),
            'revenue' => $revenuePaid,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
