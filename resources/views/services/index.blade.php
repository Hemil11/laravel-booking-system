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

    <x-filter.bar title="Filter services">
        <x-form.input
            name="search"
            label="Search"
            :value="$filters['search']"
            placeholder="Name or description…"
        />
        <x-form.select
            name="status"
            label="Status"
            :value="$filters['status']"
            :options="$statusOptions"
        />
        <x-form.input name="date_from" type="date" label="Created from" :value="$filters['date_from']" />
        <x-form.input name="date_to" type="date" label="Created to" :value="$filters['date_to']" />
        <x-slot name="actions">
            <x-button type="submit">Apply filters</x-button>
            <x-button variant="outline" href="{{ route('services.index') }}">Reset</x-button>
        </x-slot>
    </x-filter.bar>

    <x-bulk.form
        :action="route('services.bulk')"
        :status-options="$bulkStatusOptions"
        :delete-confirm="__('Archive selected services? Images are removed; you can restore from the archived filter.')"
        delete-label="{{ __('Archive selected') }}"
    >
        <x-table>
            <x-slot:head>
                <th class="w-12 px-3 py-3">
                    <input
                        type="checkbox"
                        data-bulk-select-all
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        aria-label="{{ __('Select all on this page') }}"
                    />
                </th>
                <th class="px-4 py-3">Service</th>
                <th class="px-4 py-3">Duration</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </x-slot:head>

            @forelse ($services as $service)
                <tr>
                    <td class="px-3 py-3 align-middle">
                        <input
                            type="checkbox"
                            name="ids[]"
                            value="{{ $service->id }}"
                            data-bulk-row
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            aria-label="{{ __('Select :name', ['name' => $service->name]) }}"
                        />
                    </td>
                    <td class="px-4 py-3 font-medium">
                        @unless ($service->trashed())
                            <a href="{{ route('frontend.services.show', $service) }}" class="text-brand-700 hover:underline">{{ $service->name }}</a>
                        @else
                            <span class="text-text-muted">{{ $service->name }}</span>
                        @endunless
                    </td>
                    <td class="px-4 py-3">{{ $service->duration }} min</td>
                    <td class="px-4 py-3">${{ number_format((float) $service->price, 2) }}</td>
                    <td class="px-4 py-3">
                        @if ($service->trashed())
                            <x-badge status="cancelled">{{ __('Archived') }}</x-badge>
                        @else
                            <x-badge status="active">{{ __('Active') }}</x-badge>
                        @endif
                    </td>
                    <x-table.actions>
                        @unless ($service->trashed())
                            <x-table.action variant="view" href="{{ route('frontend.services.show', $service) }}" />
                            <x-table.action variant="edit" href="{{ route('services.edit', $service) }}" />
                            <x-table.action
                                variant="delete"
                                :form-action="route('services.destroy', $service)"
                                :confirm="__('Delete this service?')"
                            />
                        @else
                            <span class="text-xs text-text-muted">{{ __('No actions') }}</span>
                        @endunless
                    </x-table.actions>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-text-subtle">No services found.</td>
                </tr>
            @endforelse
        </x-table>
    </x-bulk.form>

    <x-pagination class="mt-8" :paginator="$services" />
@endsection
