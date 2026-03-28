@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
@endphp

<div class="space-y-6">
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
            :value="$service?->price"
            min="0"
            max="99999999.99"
            step="0.01"
            required
        />
    </div>

    <div class="space-y-1.5">
        <label for="image" class="block text-sm font-semibold text-text">{{ __('Image') }} <span class="font-normal text-text-muted">({{ __('optional') }})</span></label>
        <input
            id="image"
            name="image"
            type="file"
            class="input py-2 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 @error('image') input-error @enderror"
            accept="image/jpeg,image/png,image/gif,image/webp"
        >
        @error('image')
            <p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>
        @enderror
        @if ($service?->image_path)
            <div class="mt-4 rounded-xl border border-border bg-background-muted/50 p-4">
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-text-muted">{{ __('Current image') }}</p>
                <img src="{{ service_image_url($service->image_path) }}" alt="" class="max-h-40 max-w-full rounded-lg border border-border object-cover shadow-sm">
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3 border-t border-border pt-6">
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">{{ __('Cancel') }}</x-button>
    </div>
</div>
