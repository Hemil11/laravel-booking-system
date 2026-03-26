@extends('layouts.app')

@section('title', 'Design System Example')

@section('content')
    <div class="space-y-8">
        <x-card header="Typography" class="card-hover">
            <h1 class="text-h1 mb-2">Booking SaaS Dashboard</h1>
            <h2 class="text-h2 mb-2">Operational Overview</h2>
            <h3 class="text-h3 mb-2">Today&apos;s Metrics</h3>
            <p class="text-body text-text-muted">Clean, modern typography improves scannability for bookings, revenue, and service insights.</p>
        </x-card>

        <x-card header="Buttons">
            <div class="flex flex-wrap gap-3">
                <x-button>Primary button</x-button>
                <x-button variant="secondary">Secondary button</x-button>
                <x-button variant="outline">Outline button</x-button>
            </div>
        </x-card>

        <x-card header="Input + Error">
            <div class="grid gap-4 md:grid-cols-2">
                <x-form.input name="service_name" label="Service Name" placeholder="Hair Spa" />
                <x-form.input name="price" label="Price" type="number" placeholder="49.99" />
            </div>
        </x-card>

        <section class="grid gap-4 md:grid-cols-3">
            <x-card class="card-hover">
                <p class="text-small text-text-muted">Revenue</p>
                <p class="text-h2">$24,580</p>
                <x-badge status="success">+12.6% this month</x-badge>
            </x-card>
            <x-card class="card-hover">
                <p class="text-small text-text-muted">Bookings</p>
                <p class="text-h2">1,482</p>
                <x-badge status="pending">Pending review</x-badge>
            </x-card>
            <x-card class="card-hover">
                <p class="text-small text-text-muted">Top Service</p>
                <p class="text-h2">Hair Spa</p>
                <x-badge status="confirmed">Confirmed</x-badge>
            </x-card>
        </section>

        <x-card header="Styled Table">
            <x-table>
                <x-slot:head>
                    <th class="px-4 py-3">Booking</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Status</th>
                </x-slot:head>

                <tr>
                    <td class="px-4 py-3">#BKG-001</td>
                    <td class="px-4 py-3">Ava Smith</td>
                    <td class="px-4 py-3"><x-badge status="confirmed" /></td>
                </tr>
                <tr>
                    <td class="px-4 py-3">#BKG-002</td>
                    <td class="px-4 py-3">Noah Brown</td>
                    <td class="px-4 py-3"><x-badge status="cancelled" /></td>
                </tr>
            </x-table>
        </x-card>
    </div>

    <x-modal id="demo-modal" title="Confirmation" :show="false">
        Your modal content goes here.
        <x-slot:footer>
            <x-button variant="secondary" type="button">Close</x-button>
            <x-button type="button">Confirm</x-button>
        </x-slot:footer>
    </x-modal>
@endsection
