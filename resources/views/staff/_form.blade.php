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

<div class="space-y-5">
    <div class="space-y-1.5">
        <label for="user_id" class="block text-sm font-medium text-text">Linked user</label>
        <select id="user_id" name="user_id" required class="input @error('user_id') input-error @enderror">
            <option value="">— Select user —</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $staff?->user_id) == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        @error('user_id')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="full_name" class="block text-sm font-medium text-text">Display name</label>
        <input id="full_name" name="full_name" type="text" class="input @error('full_name') input-error @enderror" value="{{ old('full_name', $staff?->full_name) }}" required maxlength="150">
        @error('full_name')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="phone" class="block text-sm font-medium text-text">Phone</label>
        <input id="phone" name="phone" type="text" class="input @error('phone') input-error @enderror" value="{{ old('phone', $staff?->phone) }}" maxlength="30">
        @error('phone')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <label for="bio" class="block text-sm font-medium text-text">Bio</label>
        <textarea id="bio" name="bio" class="input min-h-28 resize-y @error('bio') input-error @enderror">{{ old('bio', $staff?->bio) }}</textarea>
        @error('bio')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="flex flex-wrap gap-6">
        <div class="space-y-1.5">
            <label for="start_time" class="block text-sm font-medium text-text">Working hours — start</label>
            <input id="start_time" name="start_time" type="time" class="input @error('start_time') input-error @enderror" value="{{ old('start_time', $time($staff?->start_time, '09:00')) }}" required>
            @error('start_time')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="space-y-1.5">
            <label for="end_time" class="block text-sm font-medium text-text">Working hours — end</label>
            <input id="end_time" name="end_time" type="time" class="input @error('end_time') input-error @enderror" value="{{ old('end_time', $time($staff?->end_time, '17:00')) }}" required>
            @error('end_time')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="space-y-1.5">
        <label for="services" class="block text-sm font-medium text-text">Services offered</label>
        <select id="services" name="services[]" multiple class="input min-h-32 @error('services') input-error @enderror @error('services.*') input-error @enderror">
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected(collect(old('services', $selectedServiceIds ?? []))->contains($service->id))>
                    {{ $service->name }} ({{ $service->duration }} min — {{ number_format((float) $service->price, 2) }})
                </option>
            @endforeach
        </select>
        <div class="mt-1 text-xs text-text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</div>
        @error('services')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
        @error('services.*')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="space-y-1.5">
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-text">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $staff?->is_active ?? true)) class="h-4 w-4 rounded border-border text-brand-600 focus:ring-brand-300">
            Active
        </label>
        @error('is_active')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="flex flex-wrap gap-2">
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">Cancel</x-button>
    </div>
</div>
