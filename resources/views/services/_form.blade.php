@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
@endphp

<div class="space-y-8">
    <x-form.input
        name="name"
        label="{{ __('Name') }}"
        :value="$service?->name"
        maxlength="120"
        autocomplete="off"
        required
        placeholder="{{ __('e.g. Deep cleaning') }}"
    />

    <x-form.textarea
        name="description"
        label="{{ __('Description') }}"
        :hint="__('Shown to customers when they browse services.')"
        :value="$service?->description"
        rows="5"
        maxlength="5000"
        placeholder="{{ __('What customers can expect…') }}"
    />

    <div class="grid gap-6 sm:grid-cols-2">
        <x-form.input
            name="duration"
            type="number"
            label="{{ __('Duration (minutes)') }}"
            :hint="__('How long one appointment takes.')"
            :value="$service?->duration"
            min="1"
            max="10080"
            step="1"
            required
        />
        <x-form.input
            name="price"
            type="number"
            label="{{ __('Price (USD)') }}"
            :hint="__('Use dollars; decimals allowed (e.g. 49.99).')"
            :value="$service?->price"
            min="0"
            max="99999999.99"
            step="0.01"
            required
        />
    </div>

    <x-form.file
        name="image"
        label="{{ __('Image') }}"
        accept="image/jpeg,image/png,image/gif,image/webp"
    />

    @if ($service?->image_path)
        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Current image') }}</p>
            <img src="{{ service_image_url($service->image_path) }}" alt="" class="max-h-40 max-w-full rounded-lg border border-gray-200 object-cover shadow-sm">
        </div>
    @endif

    <x-admin.form-actions>
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">{{ __('Cancel') }}</x-button>
    </x-admin.form-actions>
</div>
