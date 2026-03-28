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

        <x-card header="Buttons (btn-primary, btn-secondary, btn-danger)">
            <div class="flex flex-wrap gap-3">
                <x-button>Primary</x-button>
                <x-button variant="secondary">Secondary</x-button>
                <x-button variant="outline">Outline (secondary)</x-button>
                <x-button variant="danger">Danger</x-button>
            </div>
            <p class="mt-3 text-small text-text-muted">Use <code class="rounded bg-background-muted px-1 py-0.5 text-xs">class=&quot;btn-*&quot;</code> on <code class="rounded bg-background-muted px-1 py-0.5 text-xs">&lt;button&gt;</code> or <code class="rounded bg-background-muted px-1 py-0.5 text-xs">&lt;a&gt;</code>, or the <code class="rounded bg-background-muted px-1 py-0.5 text-xs">x-button</code> component.</p>
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

        <x-card header="Table (striped, hover, actions)">
            <x-table>
                <x-slot:head>
                    <th class="px-4 py-3">Booking</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </x-slot:head>

                <tr>
                    <td class="px-4 py-3">#BKG-001</td>
                    <td class="px-4 py-3">Ava Smith</td>
                    <td class="px-4 py-3"><x-badge status="confirmed" /></td>
                    <x-table.actions>
                        <x-table.action variant="view" href="#" />
                        <x-table.action variant="edit" href="#" />
                        {{-- Delete: <x-table.action variant="delete" :form-action="route('...')" :confirm="__('...?')" /> --}}
                    </x-table.actions>
                </tr>
                <tr>
                    <td class="px-4 py-3">#BKG-002</td>
                    <td class="px-4 py-3">Noah Brown</td>
                    <td class="px-4 py-3"><x-badge status="cancelled" /></td>
                    <x-table.actions>
                        <x-table.action variant="view" href="#" />
                        <x-table.action variant="edit" href="#" />
                    </x-table.actions>
                </tr>
            </x-table>
            <p class="mt-3 text-small text-text-muted">Disable striping or row hover with <code class="rounded bg-background-muted px-1 py-0.5 text-xs">:striped="false"</code> or <code class="rounded bg-background-muted px-1 py-0.5 text-xs">:hover="false"</code> on <code class="rounded bg-background-muted px-1 py-0.5 text-xs">x-table</code>.</p>
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
