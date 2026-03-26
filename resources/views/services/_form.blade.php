@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
@endphp

<div class="space-y-5">
    <div class="space-y-1.5">
        <label for="name" class="block text-sm font-medium text-text">Name</label>
        <input id="name" name="name" type="text" class="input @error('name') border-danger focus:border-danger focus:ring-red-200 @enderror" value="{{ old('name', $service?->name) }}" required maxlength="120" autocomplete="off">
        @error('name')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="duration" class="block text-sm font-medium text-text">Duration (minutes)</label>
        <input id="duration" name="duration" type="number" class="input @error('duration') border-danger focus:border-danger focus:ring-red-200 @enderror" min="1" max="10080" step="1" value="{{ old('duration', $service?->duration) }}" required>
        @error('duration')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="price" class="block text-sm font-medium text-text">Price</label>
        <input id="price" name="price" type="number" class="input @error('price') border-danger focus:border-danger focus:ring-red-200 @enderror" min="0" max="99999999.99" step="0.01" value="{{ old('price', $service?->price) }}" required>
        @error('price')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="image" class="block text-sm font-medium text-text">Image (optional)</label>
        <input id="image" name="image" type="file" class="input py-2 @error('image') border-danger focus:border-danger focus:ring-red-200 @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
        @error('image')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
        @if ($service?->image_path)
            <p class="mt-2 text-small text-text-muted">Current image:</p>
            <img src="{{ media_url($service->image_path) }}" alt="" class="max-w-[220px] rounded-xl border border-border shadow-sm">
        @endif
    </div>

    <div class="flex flex-wrap gap-2 pt-1">
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">Cancel</x-button>
    </div>
</div>
