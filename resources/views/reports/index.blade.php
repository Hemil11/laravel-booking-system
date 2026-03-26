@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <h1 class="page-title">Reports</h1>
    <p class="page-subtitle">Bookings trends, revenue summary, and top-performing services.</p>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary small">Revenue today</div>
                    <div class="h4 mb-0">${{ number_format($revenue['today'], 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary small">Revenue this week</div>
                    <div class="h4 mb-0">${{ number_format($revenue['this_week'], 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary small">Revenue this month</div>
                    <div class="h4 mb-0">${{ number_format($revenue['this_month'], 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-secondary small">Revenue all time</div>
                    <div class="h4 mb-0">${{ number_format($revenue['all_time'], 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">Bookings per day (last 7 days)</div>
                <div class="card-body">
                    <canvas id="dailyBookingsChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">Bookings per week (last 8 weeks)</div>
                <div class="card-body">
                    <canvas id="weeklyBookingsChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">Top services</div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th class="text-end">Bookings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topServices as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td class="text-end">{{ $service->bookings_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-secondary py-4">No booking data available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const dailyCtx = document.getElementById('dailyBookingsChart');
            const weeklyCtx = document.getElementById('weeklyBookingsChart');

            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: @json($dailyLabels),
                    datasets: [{
                        label: 'Bookings',
                        data: @json($dailyCounts),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: @json($weekLabels),
                    datasets: [{
                        label: 'Bookings',
                        data: @json($weekCounts),
                        backgroundColor: '#60a5fa'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        })();
    </script>
@endpush
