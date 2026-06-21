<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Service;
use App\Support\PerformanceCache;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __invoke(): View
    {
        $data = Cache::remember(
            PerformanceCache::REPORTS_PAGE,
            config('performance.reports_ttl'),
            static function (): array {
                return self::buildReportPayload();
            }
        );

        return view('reports.index', $data);
    }

    /**
     * @return array<string, mixed>
     */
    protected static function buildReportPayload(): array
    {
        $today = Carbon::today();

        [$dailyLabels, $dailyCounts] = self::dailyBookingSeries($today);
        [$weekLabels, $weekCounts] = self::weeklyBookingSeries($today);
        $revenue = self::revenueSummary($today);
        $topServices = self::topServicesByBookings();

        return [
            'dailyLabels' => $dailyLabels,
            'dailyCounts' => $dailyCounts,
            'weekLabels' => $weekLabels,
            'weekCounts' => $weekCounts,
            'revenue' => $revenue,
            'topServices' => $topServices,
        ];
    }

    /**
     * @return array{0: list<string>, 1: list<int>}
     */
    protected static function dailyBookingSeries(Carbon $today): array
    {
        $dailyLabels = [];
        $dailyCounts = [];
        $dailyRaw = Booking::query()
            ->select('date', DB::raw('COUNT(*) as total'))
            ->whereDate('date', '>=', $today->copy()->subDays(6)->toDateString())
            ->groupBy('date')
            ->pluck('total', 'date');

        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $key = $day->toDateString();
            $dailyLabels[] = $day->format('D');
            $dailyCounts[] = (int) ($dailyRaw[$key] ?? 0);
        }

        return [$dailyLabels, $dailyCounts];
    }

    /**
     * @return array{0: list<string>, 1: list<int>}
     */
    protected static function weeklyBookingSeries(Carbon $today): array
    {
        $weekLabels = [];
        $weekCounts = [];

        $rangeStart = $today->copy()->startOfWeek()->subWeeks(7)->toDateString();
        $rangeEnd = $today->copy()->endOfWeek()->toDateString();

        $bookingsByDate = Booking::query()
            ->select('date', DB::raw('COUNT(*) as total'))
            ->whereBetween('date', [$rangeStart, $rangeEnd])
            ->groupBy('date')
            ->pluck('total', 'date');

        for ($i = 7; $i >= 0; $i--) {
            $start = $today->copy()->startOfWeek()->subWeeks($i);
            $end = $start->copy()->endOfWeek();
            $weekLabels[] = $start->format('M d');

            $sum = 0;
            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                $sum += (int) ($bookingsByDate[$d->toDateString()] ?? 0);
            }
            $weekCounts[] = $sum;
        }

        return [$weekLabels, $weekCounts];
    }

    /**
     * @return array{today: float, this_week: float, this_month: float, all_time: float}
     */
    protected static function revenueSummary(Carbon $today): array
    {
        if (! Schema::hasTable('invoices')) {
            return [
                'today' => 0.0,
                'this_week' => 0.0,
                'this_month' => 0.0,
                'all_time' => 0.0,
            ];
        }

        $driver = Schema::getConnection()->getDriverName();
        $dateExpr = match ($driver) {
            'sqlite' => 'date(created_at)',
            default => 'DATE(created_at)',
        };

        $weekStart = $today->copy()->startOfWeek()->startOfDay();
        $weekEnd = $today->copy()->endOfWeek()->endOfDay();
        $monthStart = $today->copy()->startOfMonth()->startOfDay();
        $monthEnd = $today->copy()->endOfMonth()->endOfDay();

        $row = Invoice::query()
            ->where('status', Invoice::STATUS_PAID)
            ->selectRaw(
                "SUM(CASE WHEN {$dateExpr} = ? THEN total ELSE 0 END) as rev_today, ".
                'SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN total ELSE 0 END) as rev_week, '.
                'SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN total ELSE 0 END) as rev_month, '.
                'SUM(COALESCE(total, 0)) as rev_all',
                [
                    $today->toDateString(),
                    $weekStart->toDateTimeString(),
                    $weekEnd->toDateTimeString(),
                    $monthStart->toDateTimeString(),
                    $monthEnd->toDateTimeString(),
                ]
            )
            ->first();

        return [
            'today' => (float) ($row->rev_today ?? 0),
            'this_week' => (float) ($row->rev_week ?? 0),
            'this_month' => (float) ($row->rev_month ?? 0),
            'all_time' => (float) ($row->rev_all ?? 0),
        ];
    }

    /**
     * @return Collection<int, object>
     */
    protected static function topServicesByBookings()
    {
        return Service::query()
            ->leftJoin('bookings', 'bookings.service_id', '=', 'services.id')
            ->select('services.id', 'services.name', DB::raw('COUNT(bookings.id) as bookings_count'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();
    }
}
