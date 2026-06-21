@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->class('space-y-4') }}>
    @if (filled($title))
        <div>
            <h2 class="text-sm font-semibold text-gray-900">{{ $title }}</h2>
            @if (filled($description))
                <p class="mt-1 text-xs text-gray-600">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>
</div>
