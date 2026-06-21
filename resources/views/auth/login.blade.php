@extends('layouts.auth')

@section('title', __('Log In'))

@section('content')
    <div class="auth-shell">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl font-display">{{ __('Welcome back') }}</h1>
            <p class="mt-2 text-sm leading-relaxed text-slate-400">
                {{ __('Sign in to continue to :app.', ['app' => config('app.name')]) }}
            </p>
        </div>

        <div class="auth-card">
            <form method="post" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="auth-field-label">{{ __('Email Address') }}</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="auth-input @error('email') input-error @enderror"
                        placeholder="{{ __('you@example.com') }}"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs font-medium text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="auth-field-label">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="auth-input @error('password') input-error @enderror"
                        placeholder="{{ __('Enter your password') }}"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <label for="remember" class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-slate-400">
                        <input id="remember" name="remember" type="checkbox" value="1" class="checkbox">
                        <span>{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link text-sm font-semibold sm:text-right">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <div class="pt-1">
                    <button type="submit" class="auth-cta">
                        {{ __('Sign In') }}
                    </button>
                </div>
            </form>
        </div>

        @if (Route::has('register'))
            <p class="mt-8 text-center text-sm text-slate-400">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="link font-semibold">{{ __('Create an account') }}</a>
            </p>
        @endif
    </div>
@endsection
