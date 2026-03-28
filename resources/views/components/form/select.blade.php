@props([
    'name',
    'label' => null,
    'value' => null,
    'options' => [],
    'emptyOption' => null,
    'required' => false,
])

@php
    $inputId = $attributes->get('id', $name);
    $current = old($name, $value);
    $hasError = $errors->has($name);
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

    <select
        {{ $attributes->merge([
            'id' => $inputId,
            'name' => $name,
        ])->class([
            'input',
            'input-error' => $hasError,
        ]) }}
        @required($required)
    >
        @if ($emptyOption !== null)
            <option value="">{{ $emptyOption }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
    @enderror
</div>
