@extends('layouts.app')

@section('title', 'Admin dashboard — ' . config('app.name'))

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.25rem;
    }
    .stat-card .label {
        font-size: 0.8125rem;
        color: var(--muted);
        font-weight: 500;
        margin: 0 0 0.35rem;
    }
    .stat-card .value {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: -0.02em;
    }
</style>

<h1>Admin dashboard</h1>
<p style="color: var(--muted); margin-top: -0.5rem; margin-bottom: 1.25rem;">Overview of your booking system.</p>

<div class="dashboard-grid">
    <div class="stat-card">
        <p class="label">Total users</p>
        <p class="value">{{ number_format($stats['users']) }}</p>
    </div>
    <div class="stat-card">
        <p class="label">Total bookings</p>
        <p class="value">{{ number_format($stats['bookings']) }}</p>
    </div>
    <div class="stat-card">
        <p class="label">Total services</p>
        <p class="value">{{ number_format($stats['services']) }}</p>
    </div>
    <div class="stat-card">
        <p class="label">Today’s bookings</p>
        <p class="value">{{ number_format($stats['todays_bookings']) }}</p>
    </div>
</div>

<div class="card">
    <p style="margin: 0; font-size: 0.875rem; color: var(--muted);">
        “Today” uses the application timezone (<code style="font-size: 0.8125rem;">{{ config('app.timezone') }}</code>) and matches bookings where the appointment date is today.
    </p>
</div>
@endsection
