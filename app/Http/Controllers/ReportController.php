<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __invoke(): View
    {
        $today = Carbon::today();

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

        $weekLabels = [];
        $weekCounts = [];
        for ($i = 7; $i >= 0; $i--) {
            $start = $today->copy()->startOfWeek()->subWeeks($i);
            $end = $start->copy()->endOfWeek();
            $weekLabels[] = $start->format('M d');
            $weekCounts[] = Booking::query()
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->count();
        }

        $revenue = [
            'today' => (float) Invoice::query()
                ->where('status', 'paid')
                ->whereDate('created_at', $today->toDateString())
                ->sum('total'),
            'this_week' => (float) Invoice::query()
                ->where('status', 'paid')
                ->whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])
                ->sum('total'),
            'this_month' => (float) Invoice::query()
                ->where('status', 'paid')
                ->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])
                ->sum('total'),
            'all_time' => (float) Invoice::query()
                ->where('status', 'paid')
                ->sum('total'),
        ];

        $topServices = Service::query()
            ->leftJoin('bookings', 'bookings.service_id', '=', 'services.id')
            ->select('services.id', 'services.name', DB::raw('COUNT(bookings.id) as bookings_count'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        return view('reports.index', [
            'dailyLabels' => $dailyLabels,
            'dailyCounts' => $dailyCounts,
            'weekLabels' => $weekLabels,
            'weekCounts' => $weekCounts,
            'revenue' => $revenue,
            'topServices' => $topServices,
        ]);
    }
}
