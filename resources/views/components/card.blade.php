@props([
    'header' => null,
])

<div {{ $attributes->class('card') }}>
    @if (filled($header) || isset($headerActions))
        <div class="mb-6 flex items-center justify-between gap-3 border-b border-gray-200 pb-4">
            <h3 class="text-base font-semibold text-gray-900">{{ $header }}</h3>
            @isset($headerActions)
                <div>{{ $headerActions }}</div>
            @endisset
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>
