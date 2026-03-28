@props([
    'title',
    'description' => null,
    'backHref' => null,
    'backLabel' => null,
])

@php
    $backLabel = $backLabel ?? __('Back');
@endphp

<div {{ $attributes->class('mx-auto max-w-3xl') }}>
    @if ($backHref)
        <a
            href="{{ $backHref }}"
            class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 transition hover:text-brand-900"
        >
            <span aria-hidden="true">←</span>
            {{ $backLabel }}
        </a>
    @endif

    <header class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h1>
        @if (filled($description))
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">{{ $description }}</p>
        @endif
    </header>

    {{ $slot }}
</div>
