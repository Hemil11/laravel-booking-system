@php
    /** @var \App\Models\User|null $user */
    $user = $user ?? null;
    $isEdit = $user !== null;
    $selectedRoleIds = old('role_ids', $user ? $user->roles->pluck('id')->all() : []);
@endphp

<div class="space-y-8">
    <x-form.input name="name" label="{{ __('Full name') }}" :value="$user?->name" required autocomplete="name" />

    <x-form.input name="email" type="email" label="{{ __('Email') }}" :value="$user?->email" required autocomplete="email" />

    @if ($isEdit)
        <div class="space-y-6">
            <x-form.input name="password" type="password" label="{{ __('New password') }}" autocomplete="new-password" />
            <x-form.input name="password_confirmation" type="password" label="{{ __('Confirm new password') }}" autocomplete="new-password" />
            <p class="-mt-2 text-xs text-gray-600">{{ __('Leave password fields empty to keep the current password.') }}</p>
        </div>
    @else
        <div class="space-y-6">
            <x-form.input name="password" type="password" label="{{ __('Password') }}" required autocomplete="new-password" />
            <x-form.input name="password_confirmation" type="password" label="{{ __('Confirm password') }}" required autocomplete="new-password" />
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4">
        <label class="flex cursor-pointer items-start gap-3">
            <input
                type="checkbox"
                name="email_verified"
                value="1"
                class="checkbox mt-1"
                @checked((string) old('email_verified', $user?->email_verified_at ? '1' : '0') === '1')
            >
            <span>
                <span class="block text-sm font-semibold text-gray-900">{{ __('Mark email as verified') }}</span>
                <span class="mt-0.5 block text-xs text-gray-600">{{ __('User can sign in without completing email verification.') }}</span>
            </span>
        </label>
    </div>

    @if ($canEditRoles)
        <fieldset class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
            <legend class="px-0.5 text-sm font-semibold text-gray-900">{{ __('Roles') }}</legend>
            <p class="text-xs text-gray-600">{{ __('Permissions are inherited from assigned roles.') }}</p>
            <div class="space-y-2.5 pt-1">
                @foreach ($roles as $role)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-transparent px-2 py-1.5 transition hover:bg-gray-50">
                        <input
                            type="checkbox"
                            name="role_ids[]"
                            value="{{ $role->id }}"
                            class="checkbox"
                            @checked(in_array($role->id, $selectedRoleIds, true))
                        >
                        <span class="text-sm font-medium text-gray-800">{{ ucfirst($role->name) }}</span>
                    </label>
                @endforeach
            </div>
            @if ($errors->has('role_ids') || $errors->has('role_ids.*'))
                <p class="text-xs font-medium text-danger" role="alert">
                    {{ $errors->first('role_ids') ?: $errors->first('role_ids.*') }}
                </p>
            @endif
        </fieldset>
    @else
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            {{ __('Your own roles cannot be changed from this form. Ask another administrator if you need a different role.') }}
        </div>
    @endif

    <x-admin.form-actions>
        <x-button type="submit">{{ $submitLabel }}</x-button>
        <x-button variant="outline" href="{{ $cancelUrl }}">{{ __('Cancel') }}</x-button>
    </x-admin.form-actions>
</div>
