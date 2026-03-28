@props([
    'align' => 'right',
])

<td {{ $attributes->class([
    'px-4 py-3 align-middle',
    'text-right' => $align === 'right',
    'text-left' => $align === 'left',
    'text-center' => $align === 'center',
]) }}>
    <div @class([
        'flex flex-wrap items-center gap-2',
        'justify-end' => $align === 'right',
        'justify-start' => $align === 'left',
        'justify-center' => $align === 'center',
    ])>
        {{ $slot }}
    </div>
</td>
