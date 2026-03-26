@extends('layouts.app')

@section('title', 'Admin dashboard — ' . config('app.name'))

@section('content')
<h1 class="page-title">Dashboard</h1>
<p class="page-subtitle">A quick overview of booking platform activity.</p>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-secondary small">Total users</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['users']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-secondary small">Total bookings</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['bookings']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-secondary small">Total services</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['services']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-secondary small">Today's bookings</div>
                <div class="display-6 fw-semibold">{{ number_format($stats['todays_bookings']) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body text-secondary">
        "Today" uses app timezone (<code>{{ config('app.timezone') }}</code>) and matches appointment date records.
    </div>
</div>
@endsection
