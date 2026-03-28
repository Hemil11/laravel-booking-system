@props([
    'striped' => true,
    'hover' => true,
])

@php
    $tbodyClasses = 'divide-y divide-border text-sm text-text';
    if ($striped) {
        $tbodyClasses .= ' [&>tr:nth-child(even)]:bg-background-muted/60';
    }
    if ($hover) {
        $tbodyClasses .= ' [&>tr]:transition-colors [&>tr:hover]:bg-background-muted';
    }
@endphp

<div {{ $attributes->class('overflow-x-auto rounded-2xl border border-border bg-background-elevated shadow-soft') }}>
    <table class="min-w-full divide-y divide-border">
        @isset($head)
            <thead class="bg-background-muted/70 text-left text-xs font-semibold uppercase tracking-wide text-text-muted">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endisset

        <tbody @class([$tbodyClasses])>
            {{ $slot }}
        </tbody>
    </table>
</div>
