@extends('layouts.admin')

@section('title', 'Services')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-h1 text-text">Services</h1>
            <p class="mt-2 text-small text-text-muted">Manage bookable services and pricing.</p>
        </div>
        <x-button href="{{ route('services.create') }}">Add service</x-button>
    </div>

    <x-card class="mb-6" header="Search services">
        <form method="get" class="grid gap-3 sm:grid-cols-[1fr_auto_auto]">
            <x-form.input name="search" label="Keyword" :value="$search ?? ''" placeholder="Service name..." />
            <div class="self-end">
                <x-button type="submit">Search</x-button>
            </div>
            <div class="self-end">
                <x-button variant="outline" href="{{ route('services.index') }}">Reset</x-button>
            </div>
        </form>
    </x-card>

    <x-table>
        <x-slot:head>
            <th class="px-4 py-3">Service</th>
            <th class="px-4 py-3">Duration</th>
            <th class="px-4 py-3">Price</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Actions</th>
        </x-slot:head>

        @forelse ($services as $service)
            <tr>
                <td class="px-4 py-3 font-medium">
                    <a href="{{ route('services.show', $service) }}" class="text-brand-700 hover:underline">{{ $service->name }}</a>
                </td>
                <td class="px-4 py-3">{{ $service->duration }} min</td>
                <td class="px-4 py-3">${{ number_format((float) $service->price, 2) }}</td>
                <td class="px-4 py-3"><x-badge status="active">Active</x-badge></td>
                <td class="px-4 py-3">
                    <div class="flex justify-end gap-2">
                        <x-button variant="secondary" href="{{ route('services.edit', $service) }}">Edit</x-button>
                        <form action="{{ route('services.destroy', $service) }}" method="post" onsubmit="return confirm('Delete this service?');">
                            @csrf
                            @method('DELETE')
                            <x-button class="!bg-danger hover:!bg-red-700" type="submit">Delete</x-button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-text-subtle">No services found.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
@endsection
