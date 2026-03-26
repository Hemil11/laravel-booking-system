@extends('layouts.app')

@section('title', 'My bookings')

@section('content')
    <h1>My bookings</h1>
    <p><a href="{{ route('bookings.create') }}" class="btn btn-primary">New booking</a></p>

    <div class="card" style="margin-top: 1rem; padding: 0;">
        <table>
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
                        <td>{{ $booking->status }}</td>
                        <td><a href="{{ route('bookings.show', $booking) }}">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="color: var(--muted);">No bookings yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">{{ $bookings->links() }}</div>
@endsection
