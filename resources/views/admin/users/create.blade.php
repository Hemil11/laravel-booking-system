@extends('layouts.admin')

@section('title', __('Add user'))

@section('content')
    <x-admin.form-page
        :title="__('Add user')"
        :description="__('Create an account and assign roles. You can mark the email as verified immediately.')"
        :back-href="route('admin.users.index')"
        :back-label="__('All users')"
    >
        <x-card :header="__('Account')">
            <form method="post" action="{{ route('admin.users.store') }}" class="space-y-0">
                @csrf
                @include('admin.users._form', [
                    'user' => null,
                    'roles' => $roles,
                    'canEditRoles' => true,
                    'submitLabel' => __('Create user'),
                    'cancelUrl' => route('admin.users.index'),
                ])
            </form>
        </x-card>
    </x-admin.form-page>
@endsection
