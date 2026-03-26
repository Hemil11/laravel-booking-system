@extends('layouts.admin')

@section('title', 'Admin dashboard — ' . config('app.name'))

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-h1 text-text">Dashboard</h1>
            <p class="mt-2 text-small text-text-muted">A quick overview of booking platform activity.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn-primary">Create booking</a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <article class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft">
            <p class="text-small text-text-muted">Total users</p>
            <p class="mt-2 text-display-md text-text">{{ number_format($stats['users']) }}</p>
        </article>
        <article class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft">
            <p class="text-small text-text-muted">Total bookings</p>
            <p class="mt-2 text-display-md text-text">{{ number_format($stats['bookings']) }}</p>
        </article>
        <article class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft">
            <p class="text-small text-text-muted">Total services</p>
            <p class="mt-2 text-display-md text-text">{{ number_format($stats['services']) }}</p>
        </article>
        <article class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft">
            <p class="text-small text-text-muted">Today's bookings</p>
            <p class="mt-2 text-display-md text-text">{{ number_format($stats['todays_bookings']) }}</p>
        </article>
        <article class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft">
            <p class="text-small text-text-muted">Revenue (mock)</p>
            <p class="mt-2 text-display-md text-text">${{ number_format((float) $stats['revenue_mock'], 2) }}</p>
        </article>
    </div>

    <div class="mt-8 rounded-2xl border border-border bg-background-elevated p-6 text-sm text-text-muted shadow-soft">
        "Today" uses app timezone (<code>{{ config('app.timezone') }}</code>) and matches appointment date records.
    </div>
@endsection
