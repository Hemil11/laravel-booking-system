@props([
    'variant' => 'view',
    'href' => null,
    'formAction' => null,
    /** post | delete */
    'httpMethod' => null,
    'confirm' => null,
    'label' => null,
    /** default | icon — icon: compact square, text in sr-only + title */
    'size' => 'default',
])

@php
    $labels = [
        'view' => __('View'),
        'edit' => __('Edit'),
        'delete' => __('Delete'),
        'danger' => __('Remove'),
    ];

    $text = $label ?? ($labels[$variant] ?? __('Open'));

    $method = strtolower((string) ($httpMethod ?? (in_array($variant, ['delete', 'danger'], true) ? 'delete' : 'post')));

    $defaultConfirm = match ($variant) {
        'delete' => __('Delete this record?'),
        'danger' => __('Are you sure?'),
        default => __('Continue?'),
    };

    $confirmMessage = $confirm ?? (($formAction && $method !== 'get') ? $defaultConfirm : null);

    $btnClass = match ($variant) {
        'delete', 'danger' => 'btn-danger',
        default => 'btn-secondary',
    };

    $isIcon = $size === 'icon';
    if ($isIcon) {
        $btnClass .= ' !min-h-0 !px-2.5 !py-2';
    }
@endphp

@php
    $iconView = '<svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
    $iconEdit = '<svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>';
    $iconTrash = '<svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';

    $icon = match ($variant) {
        'edit' => $iconEdit,
        'delete', 'danger' => $iconTrash,
        default => $iconView,
    };
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->class($btnClass) }}
        @if ($isIcon)
            title="{{ $text }}"
            aria-label="{{ $text }}"
        @endif
    >
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            {!! $icon !!}
            @if ($isIcon)
                <span class="sr-only">{{ $text }}</span>
            @else
                <span>{{ $text }}</span>
            @endif
        @endif
    </a>
@elseif ($formAction)
    <form method="post" action="{{ $formAction }}" class="inline-flex">
        @csrf
        @if ($method === 'delete')
            @method('DELETE')
        @endif
        <button
            type="submit"
            {{ $attributes->class($btnClass) }}
            @if ($isIcon)
                title="{{ $text }}"
                aria-label="{{ $text }}"
            @endif
            @if ($confirmMessage)
                onclick="return confirm(@js($confirmMessage))"
            @endif
        >
            @if ($slot->isNotEmpty())
                {{ $slot }}
            @else
                {!! $icon !!}
                @if ($isIcon)
                    <span class="sr-only">{{ $text }}</span>
                @else
                    <span>{{ $text }}</span>
                @endif
            @endif
        </button>
    </form>
@else
    <button
        type="button"
        {{ $attributes->class($btnClass) }}
        @if ($isIcon)
            title="{{ $text }}"
            aria-label="{{ $text }}"
        @endif
    >
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            {!! $icon !!}
            @if ($isIcon)
                <span class="sr-only">{{ $text }}</span>
            @else
                <span>{{ $text }}</span>
            @endif
        @endif
    </button>
@endif
