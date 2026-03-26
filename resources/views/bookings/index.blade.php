@extends('layouts.admin')

@section('title', 'My bookings')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-h1 text-text">Bookings</h1>
            <p class="mt-2 text-small text-text-muted">Track upcoming, pending, and completed appointments.</p>
        </div>
        <x-button href="{{ route('bookings.create') }}">New booking</x-button>
    </div>

    <x-card class="mb-6" header="Search bookings">
        <form method="get" class="grid gap-3 sm:grid-cols-[1fr_auto_auto]">
            <x-form.input name="search" label="Keyword" :value="$search ?? ''" placeholder="Status, staff, or service..." />
            <div class="self-end">
                <x-button type="submit">Search</x-button>
            </div>
            <div class="self-end">
                <x-button variant="outline" href="{{ route('bookings.index') }}">Reset</x-button>
            </div>
        </form>
    </x-card>

    <x-table>
        <x-slot:head>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3">Time</th>
            <th class="px-4 py-3">Staff</th>
            <th class="px-4 py-3">Service</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Actions</th>
        </x-slot:head>

        @forelse ($bookings as $booking)
            <tr>
                <td class="px-4 py-3">{{ $booking->date->format('Y-m-d') }}</td>
                <td class="px-4 py-3">{{ substr((string) $booking->time, 0, 5) }}</td>
                <td class="px-4 py-3">{{ $booking->staff?->full_name ?? '—' }}</td>
                <td class="px-4 py-3">{{ $booking->service?->name ?? '—' }}</td>
                <td class="px-4 py-3"><x-badge :status="$booking->status" /></td>
                <td class="px-4 py-3">
                    <div class="flex justify-end gap-2">
                        <x-button variant="secondary" href="{{ route('bookings.show', $booking) }}">Edit</x-button>
                        @if ($booking->status !== 'cancelled')
                            <form action="{{ route('bookings.cancel', $booking) }}" method="post" onsubmit="return confirm('Cancel this booking?');">
                                @csrf
                                <x-button class="!bg-danger hover:!bg-red-700" type="submit">Delete</x-button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-text-subtle">No bookings found.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">{{ $bookings->links() }}</div>
@endsection
