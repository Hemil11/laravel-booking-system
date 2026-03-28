{{--
    Reusable data table: wrapper + optional header slot + body slot.
    Props: striped (default true), hover (default true).

    Slots:
      head — table header cells (<th>…</th>)
      default — table rows (<tr>…</tr>)

    Actions: use <x-table.actions> with <x-table.action> or <x-table.crud-actions>.
--}}
@props([
    'striped' => true,
    'hover' => true,
])

@php
    $tbodyClasses = 'divide-y divide-gray-100 text-sm text-gray-900';
    if ($striped) {
        $tbodyClasses .= ' [&>tr:nth-child(even)]:bg-gray-50/90';
    }
    if ($hover) {
        $tbodyClasses .= ' [&>tr]:transition-colors [&>tr:hover]:bg-indigo-50/60';
    }
@endphp

<div {{ $attributes->class('overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-black/5') }}>
    <table class="min-w-full divide-y divide-gray-200">
        @isset($head)
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
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
