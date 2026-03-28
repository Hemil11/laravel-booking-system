@extends('layouts.admin')

@section('title', 'Invoices')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Invoices</h1>
        <p class="mt-1 text-sm text-gray-600">Billing records linked to bookings.</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <x-table>
            <x-slot:head>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">#</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Booking</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
            </x-slot:head>

            @forelse ($invoices as $invoice)
                <tr>
                    <td class="px-4 py-3 font-mono text-sm text-gray-700">{{ $invoice->id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if ($invoice->booking)
                            <a href="{{ route('bookings.show', $invoice->booking) }}" class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                #{{ $invoice->booking->id }}
                            </a>
                            @if ($invoice->booking->service)
                                <span class="mt-0.5 block text-xs text-gray-500">{{ $invoice->booking->service->name }}</span>
                            @endif
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $invoice->booking?->user?->name ?? '—' }}
                    </td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format((float) $invoice->total, 2) }}</td>
                    <td class="px-4 py-3">
                        <x-badge status="{{ $invoice->status === 'paid' ? 'paid' : 'pending' }}">{{ $invoice->status }}</x-badge>
                    </td>
                    <x-table.actions>
                        @if ($invoice->booking)
                            <x-table.action variant="view" href="{{ route('bookings.show', $invoice->booking) }}" />
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </x-table.actions>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">No invoices yet.</td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <x-pagination class="mt-8" :paginator="$invoices" />
@endsection
