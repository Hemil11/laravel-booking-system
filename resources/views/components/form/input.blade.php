@props([
    'name',
    'label' => null,
    'labelClass' => null,
    'hint' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'authField' => false,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
    $inputValue = $type === 'password' ? '' : old($name, $value);
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

    <input
        {{ $attributes->merge([
            'id' => $inputId,
            'name' => $name,
            'type' => $type,
            'value' => $inputValue,
            'placeholder' => $placeholder ?? '',
        ])->class([
            $authField ? 'auth-input' : 'input',
            'input-error' => $hasError,
        ]) }}
        @required($required)
        @if($ariaDescribedByAttr) aria-describedby="{{ $ariaDescribedByAttr }}" @endif
    />

    @error($name)
        <p id="{{ $inputId }}-error" class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
