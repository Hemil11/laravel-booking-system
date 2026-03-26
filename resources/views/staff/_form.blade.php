@php
    /** @var \App\Models\Staff|null $staff */
    $staff = $staff ?? null;
    $time = static function (?string $value, string $default = '09:00'): string {
        if (! $value) {
            return $default;
        }

        return strlen($value) >= 5 ? substr($value, 0, 5) : $value;
    };
@endphp

<div class="field">
    <label for="user_id">Linked user</label>
    <select id="user_id" name="user_id" required>
        <option value="">— Select user —</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected(old('user_id', $staff?->user_id) == $user->id)>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
    @error('user_id')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="full_name">Display name</label>
    <input id="full_name" name="full_name" type="text" value="{{ old('full_name', $staff?->full_name) }}" required maxlength="150">
    @error('full_name')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="phone">Phone</label>
    <input id="phone" name="phone" type="text" value="{{ old('phone', $staff?->phone) }}" maxlength="30">
    @error('phone')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <label for="bio">Bio</label>
    <textarea id="bio" name="bio">{{ old('bio', $staff?->bio) }}</textarea>
    @error('bio')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field" style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
    <div>
        <label for="start_time">Working hours — start</label>
        <input id="start_time" name="start_time" type="time" value="{{ old('start_time', $time($staff?->start_time, '09:00')) }}" required>
        @error('start_time')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div>
        <label for="end_time">Working hours — end</label>
        <input id="end_time" name="end_time" type="time" value="{{ old('end_time', $time($staff?->end_time, '17:00')) }}" required>
        @error('end_time')<div class="error">{{ $message }}</div>@enderror
    </div>
</div>

<div class="field">
    <label for="services">Services offered</label>
    <select id="services" name="services[]" multiple>
        @foreach ($services as $service)
            <option value="{{ $service->id }}" @selected(collect(old('services', $selectedServiceIds ?? []))->contains($service->id))>
                {{ $service->name }} ({{ $service->duration }} min — {{ number_format((float) $service->price, 2) }})
            </option>
        @endforeach
    </select>
    <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 0.25rem;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</div>
    @error('services')<div class="error">{{ $message }}</div>@enderror
    @error('services.*')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="field">
    <input type="hidden" name="is_active" value="0">
    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $staff?->is_active ?? true))>
        Active
    </label>
    @error('is_active')<div class="error">{{ $message }}</div>@enderror
</div>

<div class="actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ $cancelUrl }}" class="btn btn-ghost">Cancel</a>
</div>
