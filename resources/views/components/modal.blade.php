@props([
    'id',
    'title' => null,
    'show' => false,
])

<div
    id="{{ $id }}"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    {{ $attributes->class([$show ? '' : 'hidden', 'fixed inset-0 z-50']) }}
>
    <div class="absolute inset-0 bg-gray-900/60"></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-lg ring-1 ring-black/10">
            @if (filled($title))
                <div class="border-b border-border px-5 py-4">
                    <h3 id="{{ $id }}-title" class="text-base font-semibold text-text">{{ $title }}</h3>
                </div>
            @endif

            <div class="px-5 py-4">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="flex items-center justify-end gap-2 border-t border-border px-5 py-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
