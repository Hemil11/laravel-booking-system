@extends('layouts.auth')

@section('title', __('Create Account'))

@section('content')
    <div class="auth-shell">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl font-display">{{ __('Create your account') }}</h1>
            <p class="mt-2 text-sm leading-relaxed text-slate-400">
                {{ __('Get started in less than a minute. Book services and manage scheduling.') }}
            </p>
        </div>

        <div class="auth-card">
            <form method="post" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <x-form.input
                    name="name"
                    :label="__('Full Name')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    required
                    maxlength="255"
                    :placeholder="__('Your full name')"
                    autocomplete="name"
                />

                <x-form.input
                    name="email"
                    :label="__('Email Address')"
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
                    :label="__('Confirm Password')"
                    label-class="auth-field-label"
                    :auth-field="true"
                    type="password"
                    required
                    :placeholder="__('Repeat your password')"
                    autocomplete="new-password"
                />

                <div class="pt-1">
                    <button type="submit" class="auth-cta">
                        {{ __('Create Account') }}
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-center text-sm text-slate-400">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="link font-semibold">{{ __('Sign in') }}</a>
        </p>
    </div>
@endsection
