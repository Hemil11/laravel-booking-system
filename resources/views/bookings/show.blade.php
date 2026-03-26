@extends('layouts.app')

@section('title', 'Booking #' . $booking->id)

@section('content')
    <h1>Booking #{{ $booking->id }}</h1>
    <div class="card">
        <p><strong>Status:</strong> {{ $booking->status }}</p>
        <p><strong>Date:</strong> {{ $booking->date->format('Y-m-d') }}</p>
        <p><strong>Start:</strong> {{ substr($booking->time, 0, 5) }}</p>
        <p><strong>Staff:</strong> {{ $booking->staff?->full_name }}</p>
        <p><strong>Service:</strong> {{ $booking->service?->name }} ({{ $booking->service?->duration }} min)</p>
        @if ($booking->notes)
            <p><strong>Notes:</strong> {{ $booking->notes }}</p>
        @endif

        <div class="actions" style="margin-top: 1.25rem;">
            <a href="{{ route('bookings.index') }}" class="btn btn-ghost">All bookings</a>

            @if ($booking->status === 'pending')
                <form action="{{ route('bookings.confirm', $booking) }}" method="post" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
            @endif

            @if ($booking->status !== 'cancelled')
                <form action="{{ route('bookings.cancel', $booking) }}" method="post" style="display:inline;" onsubmit="return confirm('Cancel this booking?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel booking</button>
                </form>
            @endif
        </div>
    </div>
@endsection
