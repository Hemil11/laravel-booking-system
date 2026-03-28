@extends('layouts.auth')

@section('title', __('Register'))

@section('content')
    <div class="auth-shell">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-[1.75rem]">{{ __('Create your account') }}</h1>
            <p class="mt-2 text-sm leading-relaxed text-gray-500">
                {{ __('Get started in a minute. Book services and manage your appointments.') }}
            </p>
        </div>

        <div class="auth-card">
            <form method="post" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <x-form.input
                    name="name"
                    :label="__('Name')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    required
                    maxlength="255"
                    :placeholder="__('Your full name')"
                    autocomplete="name"
                />

                <x-form.input
                    name="email"
                    :label="__('Email')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    type="email"
                    required
                    :placeholder="__('you@example.com')"
                    autocomplete="email"
                />

                <x-form.input
                    name="password"
                    :label="__('Password')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    type="password"
                    required
                    :placeholder="__('Choose a strong password')"
                    autocomplete="new-password"
                />

                <x-form.input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    type="password"
                    required
                    :placeholder="__('Repeat your password')"
                    autocomplete="new-password"
                />

                <div class="pt-1">
                    <button type="submit" class="auth-cta">
                        {{ __('Create account') }}
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="link font-semibold">{{ __('Sign in') }}</a>
        </p>
    </div>
@endsection
