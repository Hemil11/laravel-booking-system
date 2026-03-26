@props([
    'status' => 'default',
])

@php
    $status = strtolower((string) $status);
    $classes = match ($status) {
        'confirmed', 'paid', 'success', 'active' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
        'pending', 'draft', 'processing' => 'bg-amber-100 text-amber-700 ring-amber-200',
        'cancelled', 'failed', 'danger', 'inactive' => 'bg-red-100 text-red-700 ring-red-200',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {$classes}") }}>
    {{ $slot->isEmpty() ? ucfirst($status) : $slot }}
</span>
