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
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Status') }}</dt>
                        <dd class="mt-1.5"><x-badge :status="$booking->status" /></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Date') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-slate-900">{{ $booking->date->format('Y-m-d') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Start time') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-slate-900">{{ substr((string) $booking->time, 0, 5) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Staff') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-slate-900">{{ $booking->staff?->full_name ?? '—' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Service') }}</dt>
                        <dd class="mt-1.5 text-base font-semibold text-slate-900">
                            {{ $booking->service?->name ?? '—' }}
                            @if ($booking->service)
                                <span class="font-normal text-slate-500">({{ $booking->service->duration }} {{ __('min') }})</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </x-card>

            @if ($booking->invoice)
                <x-card :header="__('Invoice')">
                    <dl class="grid gap-6 sm:grid-cols-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Invoice #') }}</dt>
                            <dd class="mt-1.5 font-mono text-base font-semibold text-slate-900">{{ $booking->invoice->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Payment status') }}</dt>
                            <dd class="mt-1.5"><x-badge :status="$booking->invoice->status === 'paid' ? 'paid' : 'pending'" /></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Total') }}</dt>
                            <dd class="mt-1.5 text-base font-semibold text-slate-900">${{ number_format((float) $booking->invoice->total, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Subtotal') }}</dt>
                            <dd class="mt-1.5 text-slate-700">${{ number_format((float) $booking->invoice->amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Tax') }}</dt>
                            <dd class="mt-1.5 text-slate-700">${{ number_format((float) $booking->invoice->tax, 2) }}</dd>
                        </div>
                    </dl>
                </x-card>
            @endif

            @if ($booking->notes)
                <x-card :header="__('Customer notes')">
                    <p class="text-sm leading-relaxed text-slate-700">{{ $booking->notes }}</p>
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
                            <x-button variant="success" type="submit">{{ __('Mock payment — success') }}</x-button>
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
