@php
    /** @var \App\Models\Service|null $service */
    $service = $service ?? null;
@endphp

<div class="field">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $service?->name) }}" required maxlength="120" autocomplete="off">
    @error('name')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="duration">Duration (minutes)</label>
    <input id="duration" name="duration" type="number" min="1" max="10080" step="1" value="{{ old('duration', $service?->duration) }}" required>
    @error('duration')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="price">Price</label>
    <input id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('price', $service?->price) }}" required>
    @error('price')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="image">Image (optional)</label>
    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp">
    @error('image')<div class="error">{{ $message }}</div>@enderror
    @if ($service?->image_path)
        <p style="margin: 0.5rem 0 0; font-size: 0.875rem; color: var(--muted);">Current image:</p>
        <img src="{{ media_url($service->image_path) }}" alt="" style="max-width: 200px; margin-top: 0.35rem; border-radius: 6px; border: 1px solid var(--border);">
    @endif
</div>

<div class="actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-ghost">Cancel</a>
</div>
