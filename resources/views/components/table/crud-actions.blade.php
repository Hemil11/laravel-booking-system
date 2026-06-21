{{--
    Shorthand for a typical actions column: view (link), edit (link), delete (form).
    Omit props you do not need; optional slot appends more <x-table.action> controls.
--}}
@props([
    'viewHref' => null,
    'editHref' => null,
    'deleteFormAction' => null,
    'deleteConfirm' => null,
    'align' => 'right',
])

<x-table.actions :align="$align">
    @if ($viewHref)
        <x-table.action variant="view" :href="$viewHref" />
    @endif
    @if ($editHref)
        <x-table.action variant="edit" :href="$editHref" />
    @endif
    @if ($deleteFormAction)
        <x-table.action
            variant="delete"
            :form-action="$deleteFormAction"
            :confirm="$deleteConfirm ?? __('Delete this record?')"
        />
    @endif
    {{ $slot }}
</x-table.actions>
