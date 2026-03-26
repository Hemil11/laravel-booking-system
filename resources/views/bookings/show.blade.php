@extends('layouts.app')

@section('title', 'Booking #' . $booking->id)

@section('content')
    <h1 class="page-title">Booking #{{ $booking->id }}</h1>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($booking->status) }}</div>
            <div class="col-md-6"><strong>Date:</strong> {{ $booking->date->format('Y-m-d') }}</div>
            <div class="col-md-6"><strong>Start:</strong> {{ substr($booking->time, 0, 5) }}</div>
            <div class="col-md-6"><strong>Staff:</strong> {{ $booking->staff?->full_name }}</div>
            <div class="col-12"><strong>Service:</strong> {{ $booking->service?->name }} ({{ $booking->service?->duration }} min)</div>
        </div>

        @if ($booking->invoice)
            <hr class="my-3">
            <h2 class="h6">Invoice</h2>
            <div class="row g-2">
                <div class="col-md-6"><strong>Invoice #:</strong> {{ $booking->invoice->id }}</div>
                <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($booking->invoice->status) }}</div>
                <div class="col-md-4"><strong>Amount:</strong> {{ number_format((float) $booking->invoice->amount, 2) }}</div>
                <div class="col-md-4"><strong>Tax:</strong> {{ number_format((float) $booking->invoice->tax, 2) }}</div>
                <div class="col-md-4"><strong>Total:</strong> {{ number_format((float) $booking->invoice->total, 2) }}</div>
            </div>
        @endif
        @if ($booking->notes)
            <hr class="my-3">
            <p class="mb-0"><strong>Notes:</strong> {{ $booking->notes }}</p>
        @endif

        <div class="d-flex gap-2 flex-wrap mt-4">
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">All bookings</a>

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

            @if ($booking->invoice && $booking->status !== 'cancelled')
                <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" style="display:inline;">
                    @csrf
                    <input type="hidden" name="result" value="success">
                    <button type="submit" class="btn btn-success">Mock payment success</button>
                </form>
                <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" style="display:inline;">
                    @csrf
                    <input type="hidden" name="result" value="failure">
                    <button type="submit" class="btn btn-outline-secondary">Mock payment failure</button>
                </form>
            @endif
        </div>
        </div>
    </div>
@endsection
