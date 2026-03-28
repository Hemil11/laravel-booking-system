@props([
    'action',
    /** @var array<string, string> */
    'statusOptions' => [],
    'deleteConfirm' => null,
    'deleteLabel' => null,
    'applyLabel' => null,
    'statusHint' => null,
    'statusSelectLabel' => null,
])

@php
    $deleteLabel = $deleteLabel ?? __('Delete selected');
    $applyLabel = $applyLabel ?? __('Apply status');
    $statusHint = $statusHint ?? __('Choose a status to apply.');
    $statusSelectLabel = $statusSelectLabel ?? __('Set status');
    $hasStatus = count($statusOptions) > 0;
    $statusFieldId = 'bulk-status-'.substr(md5((string) $action), 0, 10);
@endphp

<div data-bulk-root {{ $attributes->class('relative pb-24') }}>
    <form method="post" action="{{ $action }}" data-bulk-form>
        @csrf
        <input type="hidden" name="bulk_action" value="" data-bulk-action-input />

        {{ $slot }}

        <div
            data-bulk-bar
            class="fixed bottom-4 left-4 right-4 z-50 hidden lg:left-[17rem] lg:right-8"
            role="region"
            aria-label="{{ __('Bulk actions') }}"
        >
            <div
                class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-lg ring-1 ring-slate-900/5 sm:flex-row sm:items-center sm:justify-between"
            >
                <p class="text-sm font-semibold text-slate-900">
                    <span data-bulk-count>0</span>
                    {{ __('selected') }}
                </p>
                <div class="flex flex-wrap items-center gap-2">
                    @if ($hasStatus)
                        <div class="flex flex-wrap items-center gap-2">
                            <label for="{{ $statusFieldId }}" class="sr-only">{{ $statusSelectLabel }}</label>
                            <select
                                id="{{ $statusFieldId }}"
                                name="status_value"
                                data-bulk-status
                                data-bulk-status-hint="{{ $statusHint }}"
                                class="input min-w-[11rem] py-2 text-sm"
                            >
                                <option value="">{{ __('Choose…') }}</option>
                                @foreach ($statusOptions as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button
                                type="button"
                                data-bulk-apply-status
                                class="btn-secondary whitespace-nowrap py-2 text-xs"
                            >
                                {{ $applyLabel }}
                            </button>
                        </div>
                    @endif
                    <button
                        type="button"
                        data-bulk-delete
                        data-bulk-delete-confirm="{{ $deleteConfirm }}"
                        class="btn-danger whitespace-nowrap py-2 text-xs"
                    >
                        {{ $deleteLabel }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
