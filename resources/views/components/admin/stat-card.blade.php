@props([
    'title',
    'value',
    'hint' => null,
    'tone' => 'indigo',
])

@php
    $iconWrap = match ($tone) {
        'sky' => 'bg-sky-50 text-sky-600',
        'violet' => 'bg-violet-50 text-violet-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        default => 'bg-indigo-50 text-indigo-600',
    };
@endphp

<article {{ $attributes->class('admin-stat-card flex flex-col') }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-3 text-3xl font-bold tabular-nums tracking-tight text-gray-900">{{ $value }}</p>
        </div>
        @if (isset($icon) && $icon->isNotEmpty())
            <span class="admin-stat-card-icon {{ $iconWrap }}">
                {{ $icon }}
            </span>
        @endif
    </div>
    @if ($hint)
        <p class="mt-4 text-xs leading-relaxed text-gray-500">{{ $hint }}</p>
    @endif
</article>
