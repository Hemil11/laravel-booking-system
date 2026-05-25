@props([
    'name',
    'label' => null,
    'labelClass' => null,
    'hint' => null,
    'value' => null,
    'options' => [],
    'emptyOption' => null,
    'required' => false,
])

@php
    $inputId = $attributes->get('id', $name);
    $current = old($name, $value);
    $hasError = $errors->has($name);
    $resolvedLabelClass = $labelClass ?? 'block text-sm font-semibold text-gray-900';
    $ariaDescribedBy = [];
    if ($hint) {
        $ariaDescribedBy[] = $inputId . '-hint';
    }
    if ($hasError) {
        $ariaDescribedBy[] = $inputId . '-error';
    }
    $ariaDescribedByAttr = !empty($ariaDescribedBy) ? implode(' ', $ariaDescribedBy) : null;
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

    <select
        {{ $attributes->merge([
            'id' => $inputId,
            'name' => $name,
        ])->class([
            'input',
            'input-error' => $hasError,
        ]) }}
        @required($required)
        @if($ariaDescribedByAttr) aria-describedby="{{ $ariaDescribedByAttr }}" @endif
    >
        @if ($emptyOption !== null)
            <option value="">{{ $emptyOption }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($name)
        <p id="{{ $inputId }}-error" class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
