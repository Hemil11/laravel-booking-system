@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variantClasses = match ($variant) {
        'secondary', 'outline' => 'btn-secondary',
        'danger' => 'btn-danger',
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
