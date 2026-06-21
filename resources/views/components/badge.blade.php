@props([
    'status' => 'default',
])

@php
    $status = strtolower((string) $status);
    $classes = match ($status) {
        'confirmed', 'paid', 'success', 'active' => 'bg-green-100 text-green-700 ring-green-200',
        'completed' => 'bg-sky-100 text-sky-800 ring-sky-200',
        'pending', 'draft', 'processing' => 'bg-amber-100 text-amber-700 ring-amber-200',
        'cancelled', 'failed', 'danger', 'inactive' => 'bg-red-100 text-red-700 ring-red-200',
        default => 'bg-gray-100 text-gray-700 ring-gray-200',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {$classes}") }}>
    {{ $slot->isEmpty() ? ucfirst($status) : $slot }}
</span>
