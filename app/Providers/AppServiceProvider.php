<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Policies\BookingPolicy;
use App\Policies\InvoicePolicy;
use App\Services\Invoice\InvoiceService;
use App\Services\Media\FileUploadService;
use App\Support\PerformanceCache;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileUploadService::class, function () {
            return new FileUploadService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        Gate::policy(Booking::class, BookingPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);

        Booking::created(function (Booking $booking): void {
            app(InvoiceService::class)->syncForBooking($booking);
        });

        $forgetAdminStatsCaches = static function (): void {
            Cache::forget(PerformanceCache::ADMIN_DASHBOARD_STATS);
            Cache::forget(PerformanceCache::REPORTS_PAGE);
        };

        Booking::saved($forgetAdminStatsCaches);
        Booking::deleted($forgetAdminStatsCaches);
        Invoice::saved($forgetAdminStatsCaches);
        Invoice::deleted($forgetAdminStatsCaches);

        RateLimiter::for('auth', function (Request $request): array {
            return [
                Limit::perMinute(10)->by((string) $request->ip()),
                Limit::perMinute(5)->by((string) $request->input('email')),
            ];
        });

        RateLimiter::for('payment', function (Request $request): Limit {
            return Limit::perMinute(20)->by((string) ($request->user()?->id ?? $request->ip()));
        });
    }
}
