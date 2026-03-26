@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
@endphp

<div class="mb-3">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $service?->name) }}" required maxlength="120" autocomplete="off">
    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="duration">Duration (minutes)</label>
    <input id="duration" name="duration" type="number" class="form-control" min="1" max="10080" step="1" value="{{ old('duration', $service?->duration) }}" required>
    @error('duration')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="price">Price</label>
    <input id="price" name="price" type="number" class="form-control" min="0" max="99999999.99" step="0.01" value="{{ old('price', $service?->price) }}" required>
    @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="image">Image (optional)</label>
    <input id="image" name="image" type="file" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
    @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    @if ($service?->image_path)
        <p class="mt-2 mb-1 text-secondary small">Current image:</p>
        <img src="{{ media_url($service->image_path) }}" alt="" class="img-thumbnail" style="max-width: 220px;">
    @endif
</div>

<div class="d-flex gap-2 flex-wrap">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary">Cancel</a>
</div>
