@extends('layouts.admin')

@section('title', __('Edit user'))

@section('content')
    <x-admin.form-page
        :title="__('Edit :name', ['name' => $user->name])"
        :description="__('Update profile, verification, password, and roles.')"
        :back-href="route('admin.users.index')"
        :back-label="__('All users')"
    >
        <x-card :header="__('User details')">
            <form method="post" action="{{ route('admin.users.update', $user) }}" class="space-y-0">
                @csrf
                @method('PUT')
                @include('admin.users._form', [
                    'user' => $user,
                    'roles' => $roles,
                    'canEditRoles' => $canEditRoles,
                    'submitLabel' => __('Save changes'),
                    'cancelUrl' => route('admin.users.index'),
                ])
            </form>
        </x-card>

        @if (! $user->is(auth()->user()))
            <x-card class="mt-6 border-red-100" :header="__('Danger zone')">
                <p class="mb-4 text-sm text-gray-600">
                    {{ __('Deleting this user cannot be undone. Related records may prevent deletion.') }}
                </p>
                <form method="post" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm(@js(__('Permanently delete this user?')));">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit">{{ __('Delete user') }}</x-button>
                </form>
            </x-card>
        @endif
    </x-admin.form-page>
@endsection
