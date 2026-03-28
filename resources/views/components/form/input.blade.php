@props([
    'name',
    'label' => null,
    'labelClass' => null,
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
    $resolvedLabelClass = $labelClass ?? 'block text-sm font-semibold text-text';
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
    />

    @error($name)
        <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
