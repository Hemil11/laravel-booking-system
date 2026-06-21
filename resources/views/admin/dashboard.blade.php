@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">{{ __('At a glance') }}</h2>
            <p class="mt-1.5 max-w-2xl text-sm text-gray-600">
                {{ __('Users, services, bookings, and paid invoice revenue.') }}
            </p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn-primary shrink-0 self-start sm:self-auto">
            {{ __('Create booking') }}
        </a>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card
            :title="__('Total users')"
            :value="number_format($stats['users'])"
            :hint="__('Registered accounts in the system.')"
            tone="indigo"
        >
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </x-slot>
        </x-admin.stat-card>

        <x-admin.stat-card
            :title="__('Total bookings')"
            :value="number_format($stats['bookings'])"
            :hint="__('All-time appointment records.')"
            tone="sky"
        >
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot>
        </x-admin.stat-card>

        <x-admin.stat-card
            :title="__('Total services')"
            :value="number_format($stats['services'])"
            :hint="__('Active services in the catalog (excludes archived).')"
            tone="violet"
        >
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </x-slot>
        </x-admin.stat-card>

        <x-admin.stat-card
            :title="__('Revenue')"
            :value="'$'.number_format($stats['revenue'], 2)"
            :hint="__('Sum of invoice totals marked as paid.')"
            tone="emerald"
        >
            <x-slot name="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot>
        </x-admin.stat-card>
    </div>
@endsection
