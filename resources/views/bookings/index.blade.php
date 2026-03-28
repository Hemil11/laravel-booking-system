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

    <x-filter.bar title="Filter bookings">
        <x-form.input
            name="search"
            label="Search"
            :value="$filters['search']"
            placeholder="Customer name, email, staff, service, or status…"
        />
        <x-form.select
            name="status"
            label="Status"
            :value="$filters['status']"
            :options="$statusOptions"
            empty-option="{{ __('All statuses') }}"
        />
        <x-form.input name="date_from" type="date" label="Appointment from" :value="$filters['date_from']" />
        <x-form.input name="date_to" type="date" label="Appointment to" :value="$filters['date_to']" />
        <x-slot name="actions">
            <x-button type="submit">Apply filters</x-button>
            <x-button variant="outline" href="{{ route('bookings.index') }}">Reset</x-button>
        </x-slot>
    </x-filter.bar>

    <x-bulk.form
        :action="route('bookings.bulk')"
        :status-options="$bulkStatusOptions"
        :delete-confirm="__('Cancel selected bookings? This frees the time slots.')"
        delete-label="{{ __('Cancel selected') }}"
    >
        <x-table>
            <x-slot:head>
                <th class="w-12 px-3 py-3">
                    <input
                        type="checkbox"
                        data-bulk-select-all
                        class="checkbox"
                        aria-label="{{ __('Select all on this page') }}"
                    />
                </th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Time</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Staff</th>
                <th class="px-4 py-3">Service</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </x-slot:head>

            @forelse ($bookings as $booking)
                <tr>
                    <td class="px-3 py-3 align-middle">
                        <input
                            type="checkbox"
                            name="ids[]"
                            value="{{ $booking->id }}"
                            data-bulk-row
                            class="checkbox"
                            aria-label="{{ __('Select booking #:id', ['id' => $booking->id]) }}"
                        />
                    </td>
                    <td class="px-4 py-3">{{ $booking->date->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ substr((string) $booking->time, 0, 5) }}</td>
                    <td class="px-4 py-3">
                        <div class="text-sm text-text">{{ $booking->user?->name ?? '—' }}</div>
                        @if ($booking->user?->email)
                            <div class="text-xs text-text-muted">{{ $booking->user->email }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $booking->staff?->full_name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $booking->service?->name ?? '—' }}</td>
                    <td class="px-4 py-3"><x-badge :status="$booking->status" /></td>
                    <x-table.actions>
                        <x-table.action variant="view" href="{{ route('bookings.show', $booking) }}" />
                        @if ($booking->status !== 'cancelled')
                            <x-table.action
                                variant="danger"
                                :form-action="route('bookings.cancel', $booking)"
                                http-method="post"
                                :confirm="__('Cancel this booking?')"
                                :label="__('Cancel')"
                            />
                        @endif
                    </x-table.actions>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-text-subtle">No bookings found.</td>
                </tr>
            @endforelse
        </x-table>
    </x-bulk.form>

    <x-pagination class="mt-8" :paginator="$bookings" />
@endsection
