@extends('layouts.app')

@section('title', 'My bookings')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h1 class="page-title mb-1">Bookings</h1>
            <p class="page-subtitle mb-0">Track upcoming, pending, and completed appointments.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">New booking</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Staff</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->date->format('Y-m-d') }}</td>
                        <td>{{ substr($booking->time, 0, 5) }}</td>
                        <td>{{ $booking->staff?->full_name }}</td>
                        <td>{{ $booking->service?->name }}</td>
                        <td>
                            @php
                                $badge = $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'secondary' : 'warning');
                            @endphp
                            <span class="badge text-bg-{{ $badge }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                        <td><a class="btn btn-sm btn-outline-primary" href="{{ route('bookings.show', $booking) }}">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">No bookings yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection
