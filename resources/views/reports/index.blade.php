@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">Reports</h1>
        <p class="mt-2 text-small text-text-muted">Bookings trends, revenue summary, and top-performing services.</p>
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/5">
            <p class="text-small text-text-muted">Revenue today</p>
            <p class="mt-2 text-h2 text-text">${{ number_format($revenue['today'], 2) }}</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/5">
            <p class="text-small text-text-muted">Revenue this week</p>
            <p class="mt-2 text-h2 text-text">${{ number_format($revenue['this_week'], 2) }}</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/5">
            <p class="text-small text-text-muted">Revenue this month</p>
            <p class="mt-2 text-h2 text-text">${{ number_format($revenue['this_month'], 2) }}</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/5">
            <p class="text-small text-text-muted">Revenue all time</p>
            <p class="mt-2 text-h2 text-text">${{ number_format($revenue['all_time'], 2) }}</p>
        </article>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <x-card header="Bookings per day (last 7 days)">
            <canvas id="dailyBookingsChart" height="120"></canvas>
        </x-card>

        <x-card header="Bookings per week (last 8 weeks)">
            <canvas id="weeklyBookingsChart" height="120"></canvas>
        </x-card>

        <div class="lg:col-span-2">
            <x-card header="Top services" class="p-0">
                <x-table class="rounded-none border-0 shadow-none">
                    <x-slot:head>
                        <th class="px-4 py-3">Service</th>
                        <th class="px-4 py-3 text-right">Bookings</th>
                    </x-slot:head>

                    @forelse ($topServices as $service)
                        <tr>
                            <td class="px-4 py-3">{{ $service->name }}</td>
                            <td class="px-4 py-3 text-right">{{ $service->bookings_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-text-muted">No booking data available.</td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
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
                        borderColor: '#554dff',
                        backgroundColor: 'rgba(85, 77, 255, 0.15)',
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
                        backgroundColor: '#8f95ff'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        })();
    </script>
@endpush
