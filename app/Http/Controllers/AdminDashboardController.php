<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\User;
use App\Support\PerformanceCache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

/**
 * Example: this route is registered with middleware `permission:manage_users` in `routes/web.php`.
 * That grants access only to users whose roles include the `manage_users` permission.
 */
class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = Cache::remember(
            PerformanceCache::ADMIN_DASHBOARD_STATS,
            config('performance.admin_dashboard_ttl'),
            static function (): array {
                return [
                    'users' => Schema::hasTable('users') ? User::query()->count() : 0,
                    'bookings' => Schema::hasTable('bookings') ? Booking::query()->count() : 0,
                    'services' => Schema::hasTable('services') ? Service::query()->count() : 0,
                    'revenue' => Schema::hasTable('invoices')
                        ? (float) Invoice::query()->where('status', Invoice::STATUS_PAID)->sum('total')
                        : 0.0,
                ];
            }
        );

        return view('admin.dashboard', compact('stats'));
    }
}
