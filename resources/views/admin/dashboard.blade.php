@extends('layouts.admin')

@section('title', 'Admin dashboard — ' . config('app.name'))

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Dashboard</h1>
            <p class="mt-2 max-w-xl text-sm text-gray-600">Overview of users, services, bookings, and paid revenue.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn-primary shrink-0 self-start sm:self-auto">Create booking</a>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Users --}}
        <article class="flex flex-col rounded-2xl border border-gray-200/90 bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total users</p>
                    <p class="mt-3 text-3xl font-bold tabular-nums tracking-tight text-gray-900">{{ number_format($stats['users']) }}</p>
                </div>
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-500">Registered accounts in the system</p>
        </article>

        {{-- Bookings --}}
        <article class="flex flex-col rounded-2xl border border-gray-200/90 bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total bookings</p>
                    <p class="mt-3 text-3xl font-bold tabular-nums tracking-tight text-gray-900">{{ number_format($stats['bookings']) }}</p>
                </div>
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-500">All-time appointment records</p>
        </article>

        {{-- Services --}}
        <article class="flex flex-col rounded-2xl border border-gray-200/90 bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total services</p>
                    <p class="mt-3 text-3xl font-bold tabular-nums tracking-tight text-gray-900">{{ number_format($stats['services']) }}</p>
                </div>
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-500">Bookable offerings in the catalog</p>
        </article>

        {{-- Revenue --}}
        <article class="flex flex-col rounded-2xl border border-gray-200/90 bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenue (paid)</p>
                    <p class="mt-3 text-3xl font-bold tabular-nums tracking-tight text-gray-900">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="mt-4 text-xs text-gray-500">Sum of invoice totals marked paid</p>
        </article>
    </div>

    @php
        $chartBars = [32, 48, 40, 72, 55, 68, 44];
        $chartLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    @endphp

    <div class="mt-10 rounded-2xl border border-gray-200/90 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Activity overview</h2>
                <p class="text-sm text-gray-500">Chart placeholder — connect to analytics or booking trends when ready.</p>
            </div>
            <span class="mt-2 inline-flex w-fit rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 sm:mt-0">Sample data</span>
        </div>

        <div class="mt-8">
            <div class="flex h-44 items-end gap-2 sm:h-52 sm:gap-3">
                @foreach ($chartBars as $heightPct)
                    <div class="flex min-h-0 min-w-0 flex-1 flex-col justify-end">
                        <div
                            class="w-full min-h-2 rounded-t-lg bg-gradient-to-t from-indigo-700 to-indigo-400 shadow-sm transition-[height] duration-300"
                            style="height: {{ $heightPct }}%"
                        ></div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3 flex justify-between gap-2 text-xs font-medium text-gray-500">
                @foreach ($chartLabels as $label)
                    <span class="min-w-0 flex-1 truncate text-center">{{ $label }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
