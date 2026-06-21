@extends('layouts.admin')

@section('title', __('Booking #:id', ['id' => $booking->id]))

@section('content')
    <x-admin.form-page
        :title="__('Booking #:id', ['id' => $booking->id])"
        :description="__('Details, invoice, and actions for this appointment.')"
        :back-href="route('bookings.index')"
        :back-label="__('All bookings')"
    >
        <div class="space-y-6">
            <x-card :header="__('Summary')">
                <dl class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Status') }}</dt>
                        <dd class="mt-1.5"><x-badge :status="$booking->status" /></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Date') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900">{{ $booking->date->format('Y-m-d') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Start time') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900">{{ substr((string) $booking->time, 0, 5) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Staff') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900">{{ $booking->staff?->full_name ?? '—' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Service') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-gray-900">
                            {{ $booking->service?->name ?? '—' }}
                            @if ($booking->service)
                                <span class="font-normal text-gray-500">({{ $booking->service->duration }} {{ __('min') }})</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </x-card>

            @can('updateStatus', $booking)
                <x-card :header="__('Update status')" class="border-indigo-100 ring-1 ring-indigo-100">
                    <form
                        method="post"
                        action="{{ route('bookings.update-status', $booking) }}"
                        class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-end"
                    >
                        @csrf
                        @method('PATCH')
                        <div class="min-w-[min(100%,14rem)] flex-1 sm:max-w-md">
                            <x-form.select
                                name="status"
                                label="{{ __('Booking status') }}"
                                :options="[
                                    'pending' => __('Pending'),
                                    'confirmed' => __('Confirmed'),
                                    'completed' => __('Completed'),
                                    'cancelled' => __('Cancelled'),
                                ]"
                                :value="$booking->status"
                                required
                            />
                        </div>
                        <x-button type="submit">{{ __('Save status') }}</x-button>
                    </form>
                </x-card>
            @endcan

            @if ($booking->invoice)
                <x-card :header="__('Invoice')">
                    <dl class="grid gap-6 sm:grid-cols-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Invoice #') }}</dt>
                            <dd class="mt-1.5 font-mono text-base font-semibold text-gray-900">{{ $booking->invoice->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Payment status') }}</dt>
                            <dd class="mt-1.5"><x-badge :status="$booking->invoice->status === 'paid' ? 'paid' : 'pending'" /></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Total') }}</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900">${{ number_format((float) $booking->invoice->total, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Subtotal') }}</dt>
                            <dd class="mt-1.5 text-gray-700">${{ number_format((float) $booking->invoice->amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Tax') }}</dt>
                            <dd class="mt-1.5 text-gray-700">${{ number_format((float) $booking->invoice->tax, 2) }}</dd>
                        </div>
                    </dl>
                    @can('viewPdf', $booking->invoice)
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <x-button variant="outline" href="{{ route('invoices.pdf', $booking->invoice) }}">
                                {{ __('Download PDF invoice') }}
                            </x-button>
                        </div>
                    @endcan
                </x-card>
            @endif

            @if ($booking->notes)
                <x-card :header="__('Customer notes')">
                    <p class="text-sm leading-relaxed text-gray-700">{{ $booking->notes }}</p>
                </x-card>
            @endif

            <x-card :header="__('Actions')">
                <div class="flex flex-wrap gap-3">
                    @if ($booking->status === 'pending')
                        <form action="{{ route('bookings.confirm', $booking) }}" method="post" class="inline">
                            @csrf
                            <x-button type="submit">{{ __('Confirm booking') }}</x-button>
                        </form>
                    @endif

                    @if ($booking->status !== 'cancelled')
                        <form action="{{ route('bookings.cancel', $booking) }}" method="post" class="inline" onsubmit="return confirm(@js(__('Cancel this booking?')));">
                            @csrf
                            <x-button variant="danger" type="submit">{{ __('Cancel booking') }}</x-button>
                        </form>
                    @endif

                    @if ($booking->invoice && $booking->status !== 'cancelled')
                        <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" class="inline">
                            @csrf
                            <input type="hidden" name="result" value="success">
                            <x-button type="submit">{{ __('Mock payment — success') }}</x-button>
                        </form>
                        <form action="{{ route('invoices.mock-payment', $booking->invoice) }}" method="post" class="inline">
                            @csrf
                            <input type="hidden" name="result" value="failure">
                            <x-button variant="outline" type="submit">{{ __('Mock payment — failure') }}</x-button>
                        </form>
                    @endif
                </div>
            </x-card>
        </div>
    </x-admin.form-page>
@endsection
