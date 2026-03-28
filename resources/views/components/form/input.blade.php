@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
])

@php
    $hasError = $errors->has($name);
    $inputId = $attributes->get('id', $name);
    $inputValue = $type === 'password' ? '' : old($name, $value);
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-semibold text-text">
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
            'input',
            'input-error' => $hasError,
        ]) }}
        @required($required)
    />

    @error($name)
        <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
