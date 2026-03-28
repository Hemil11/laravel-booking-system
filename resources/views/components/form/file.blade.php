@props([
    'name',
    'label' => null,
    'required' => false,
    'accept' => null,
    'hint' => null,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-semibold text-gray-900">
            {{ $label }}
            @if (! $required)
                <span class="font-normal text-gray-500">({{ __('optional') }})</span>
            @endif
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if ($hint)
        <p id="{{ $inputId }}-hint" class="text-xs text-gray-600">{{ $hint }}</p>
    @endif

    <input
        {{ $attributes->merge([
            'id' => $inputId,
            'name' => $name,
            'type' => 'file',
        ])->class([
            'input py-2 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100',
            'input-error' => $hasError,
        ]) }}
        @if ($accept) accept="{{ $accept }}" @endif
        @required($required)
    />

    @error($name)
        <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
