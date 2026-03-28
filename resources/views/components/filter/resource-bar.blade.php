{{--
    Standard admin list filters: keyword (search), status, date range + Apply / Reset.
    Expects GET query keys: search, status, date_from, date_to (controllers already validate these).

    Props:
      title, resetUrl, filters (array), statusOptions (array)
      statusAllowsAny — when true, adds blank status option (label from statusAnyLabel or __('Any'))
      statusLabel, searchLabel, searchPlaceholder, dateFromLabel, dateToLabel
    Slot: optional extra fields before the action row
--}}
@props([
    'title',
    'resetUrl',
    'filters' => [],
    'statusOptions' => [],
    'statusAllowsAny' => false,
    'statusAnyLabel' => null,
    'statusLabel' => null,
    'searchLabel' => null,
    'searchPlaceholder' => null,
    'dateFromLabel' => null,
    'dateToLabel' => null,
])

@php
    $statusAny = $statusAnyLabel ?? __('Any');
    $f = array_merge([
        'search' => '',
        'status' => null,
        'date_from' => null,
        'date_to' => null,
    ], $filters);
@endphp

<x-filter.bar :title="$title" {{ $attributes }}>
    <x-form.input
        name="search"
        :label="$searchLabel ?? __('Keyword search')"
        :value="$f['search']"
        :placeholder="$searchPlaceholder ?? __('Search…')"
    />

    @if ($statusOptions !== [])
        <x-form.select
            name="status"
            :label="$statusLabel ?? __('Status')"
            :value="$f['status'] ?? ''"
            :options="$statusOptions"
            :empty-option="$statusAllowsAny ? $statusAny : null"
        />
    @endif

    <x-form.input
        name="date_from"
        type="date"
        :label="$dateFromLabel ?? __('Date from')"
        :value="$f['date_from']"
    />
    <x-form.input
        name="date_to"
        type="date"
        :label="$dateToLabel ?? __('Date to')"
        :value="$f['date_to']"
    />

    {{ $slot }}

    <x-slot name="actions">
        <x-button type="submit">{{ __('Apply filters') }}</x-button>
        <x-button variant="outline" :href="$resetUrl">{{ __('Reset') }}</x-button>
    </x-slot>
</x-filter.bar>
