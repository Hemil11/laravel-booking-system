@extends('layouts.app')

@section('title', 'Booking #' . $booking->id)

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">Booking #{{ $booking->id }}</h1>
        <p class="mt-2 text-small text-text-muted">Booking details, invoice summary, and status actions.</p>
    </div>

    <div class="card space-y-8">
        <div class="grid gap-4 md:grid-cols-2">
            <div><span class="text-small text-text-muted">Status</span><p class="font-semibold text-text">{{ ucfirst($booking->status) }}</p></div>
            <div><span class="text-small text-text-muted">Date</span><p class="font-semibold text-text">{{ $booking->date->format('Y-m-d') }}</p></div>
            <div><span class="text-small text-text-muted">Start</span><p class="font-semibold text-text">{{ substr($booking->time, 0, 5) }}</p></div>
            <div><span class="text-small text-text-muted">Staff</span><p class="font-semibold text-text">{{ $booking->staff?->full_name }}</p></div>
            <div class="md:col-span-2"><span class="text-small text-text-muted">Service</span><p class="font-semibold text-text">{{ $booking->service?->name }} ({{ $booking->service?->duration }} min)</p></div>
        </div>

        @if ($booking->invoice)
            <div class="border-t border-border pt-6">
                <h2 class="text-h3 text-text">Invoice</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div><span class="text-small text-text-muted">Invoice #</span><p class="font-semibold text-text">{{ $booking->invoice->id }}</p></div>
                    <div><span class="text-small text-text-muted">Status</span><p class="font-semibold text-text">{{ ucfirst($booking->invoice->status) }}</p></div>
                    <div><span class="text-small text-text-muted">Amount</span><p class="font-semibold text-text">{{ number_format((float) $booking->invoice->amount, 2) }}</p></div>
                    <div><span class="text-small text-text-muted">Tax</span><p class="font-semibold text-text">{{ number_format((float) $booking->invoice->tax, 2) }}</p></div>
                    <div><span class="text-small text-text-muted">Total</span><p class="font-semibold text-text">{{ number_format((float) $booking->invoice->total, 2) }}</p></div>
                </div>
            </div>
        @endif

        @if ($booking->notes)
            <div class="border-t border-border pt-6">
                <h2 class="text-h3 text-text">Notes</h2>
                <p class="mt-2 text-small text-text-muted">{{ $booking->notes }}</p>
            </div>
        @endif

        <div class="flex flex-wrap gap-2 border-t border-border pt-6">
            <x-button variant="outline" href="{{ route('bookings.index') }}">All bookings</x-button>

            @if ($booking->status === 'pending')
                <form action="{{ route('bookings.confirm', $booking) }}" method="post" class="inline">
                    @csrf
                    <x-button type="submit">Confirm</x-button>
                </form>
            @endif

            @if ($booking->status !== 'cancelled')
                <form action="{{ route('bookings.cancel', $booking) }}" method="post" class="inline" onsubmit="return confirm('Cancel this booking?');">
                    @csrf
                    <x-button class="!bg-danger hover:!bg-red-700" type="submit">Cancel booking</x-button>
                </form>
            @endif

            @if ($booking->invoice && $booking->status !== 'cancelled')
                <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" class="inline">
                    @csrf
                    <input type="hidden" name="result" value="success">
                    <x-button class="!bg-success hover:!bg-emerald-700" type="submit">Mock payment success</x-button>
                </form>
                <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" class="inline">
                    @csrf
                    <input type="hidden" name="result" value="failure">
                    <x-button variant="outline" type="submit">Mock payment failure</x-button>
                </form>
            @endif
        </div>
    </div>
@endsection
