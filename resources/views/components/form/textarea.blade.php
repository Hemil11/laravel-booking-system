@props([
    'name',
    'label' => null,
    'labelClass' => null,
    'hint' => null,
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'rows' => 4,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
    $areaValue = old($name, $value);
    $resolvedLabelClass = $labelClass ?? 'block text-sm font-semibold text-gray-900';
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $inputId }}" class="{{ $resolvedLabelClass }}">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if ($hint)
        <p id="{{ $inputId }}-hint" class="text-xs text-gray-600">{{ $hint }}</p>
    @endif

    <textarea
        {{ $attributes->merge([
            'id' => $inputId,
            'name' => $name,
            'rows' => $rows,
            'placeholder' => $placeholder ?? '',
        ])->class([
            'input',
            'min-h-[6rem]',
            'input-error' => $hasError,
        ]) }}
        @required($required)
    >{{ $areaValue }}</textarea>

    @error($name)
        <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
