@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variantClasses = match ($variant) {
        'secondary' => 'btn-secondary',
        'outline' => 'inline-flex items-center justify-center rounded-xl border border-border-strong bg-transparent px-4 py-2.5 text-sm font-semibold text-text transition-all duration-200 hover:bg-background-muted focus:outline-none focus:ring-2 focus:ring-brand-300 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60',
        default => 'btn-primary',
    };
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->class($variantClasses) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($variantClasses) }}>
        {{ $slot }}
    </button>
@endif
