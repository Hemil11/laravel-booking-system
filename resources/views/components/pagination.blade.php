@props([
    'paginator',
])

@if ($paginator->hasPages())
    <div {{ $attributes->class('flex w-full justify-center px-2') }}>
        {{ $paginator->links() }}
    </div>
@endif
