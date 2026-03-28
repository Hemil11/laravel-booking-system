@php
    /** @var \App\Models\User|null $user */
    $user = $user ?? null;
    $isEdit = $user !== null;
    $selectedRoleIds = old('role_ids', $user ? $user->roles->pluck('id')->all() : []);
@endphp

<div class="space-y-6">
    <x-form.input name="name" label="{{ __('Full name') }}" :value="$user?->name" required autocomplete="name" />

    <x-form.input name="email" type="email" label="{{ __('Email') }}" :value="$user?->email" required autocomplete="email" />

    @if ($isEdit)
        <x-form.input name="password" type="password" label="{{ __('New password') }}" autocomplete="new-password" />
        <x-form.input name="password_confirmation" type="password" label="{{ __('Confirm new password') }}" autocomplete="new-password" />
        <p class="-mt-2 text-xs text-slate-500">{{ __('Leave password fields empty to keep the current password.') }}</p>
    @else
        <x-form.input name="password" type="password" label="{{ __('Password') }}" required autocomplete="new-password" />
        <x-form.input name="password_confirmation" type="password" label="{{ __('Confirm password') }}" required autocomplete="new-password" />
    @endif

    <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-4">
        <label class="flex cursor-pointer items-start gap-3">
            <input
                type="checkbox"
                name="email_verified"
                value="1"
                class="mt-1 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                @checked((string) old('email_verified', $user?->email_verified_at ? '1' : '0') === '1')
            >
            <span>
                <span class="block text-sm font-semibold text-slate-900">{{ __('Mark email as verified') }}</span>
                <span class="mt-0.5 block text-xs text-slate-600">{{ __('User can sign in without completing email verification.') }}</span>
            </span>
        </label>
    </div>

    @if ($canEditRoles)
        <fieldset class="space-y-3 rounded-xl border border-slate-200 p-4">
            <legend class="text-sm font-semibold text-slate-900">{{ __('Roles') }}</legend>
            <p class="text-xs text-slate-600">{{ __('Permissions are inherited from assigned roles.') }}</p>
            <div class="space-y-2.5 pt-1">
                @foreach ($roles as $role)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-transparent px-2 py-1.5 hover:bg-white">
                        <input
                            type="checkbox"
                            name="role_ids[]"
                            value="{{ $role->id }}"
                            class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500"
                            @checked(in_array($role->id, $selectedRoleIds, true))
                        >
                        <span class="text-sm font-medium text-slate-800">{{ ucfirst($role->name) }}</span>
                    </label>
                @endforeach
            </div>
            @error('role_ids')
                <p class="text-xs font-medium text-danger">{{ $message }}</p>
            @enderror
            @error('role_ids.*')
                <p class="text-xs font-medium text-danger">{{ $message }}</p>
            @enderror
        </fieldset>
    @else
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            {{ __('Your own roles cannot be changed from this form. Ask another administrator if you need a different role.') }}
        </div>
    @endif

    <div class="flex flex-wrap gap-3 border-t border-border pt-6">
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">{{ __('Cancel') }}</x-button>
    </div>
</div>
