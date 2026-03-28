@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <section class="relative overflow-hidden rounded-3xl border border-border/80 bg-gradient-to-br from-brand-50 via-white to-slate-100 p-4 shadow-soft sm:p-6 lg:p-8">
        <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-brand-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-accent-200/40 blur-3xl"></div>

        <div class="relative grid gap-6 lg:grid-cols-2">
            <div class="hidden rounded-2xl border border-brand-100 bg-brand-600 p-8 text-white shadow-soft lg:block">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-100">Welcome back</p>
                <h1 class="mt-4 text-3xl font-bold leading-tight text-white">Manage bookings with a premium admin experience.</h1>
                <p class="mt-4 text-sm text-brand-100">
                    Access schedules, customer appointments, and service insights from one clean dashboard.
                </p>
                <div class="mt-8 rounded-xl border border-brand-300/30 bg-white/10 p-4">
                    <p class="text-sm text-brand-50">Secure sign-in with protected session handling for your booking operations.</p>
                </div>
            </div>

            <div class="mx-auto w-full max-w-xl rounded-2xl border border-border bg-white p-6 shadow-soft sm:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-text">Sign in to your account</h2>
                    <p class="mt-2 text-sm text-text-muted">Welcome back. Enter your credentials to continue.</p>
                </div>

                <form method="post" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-semibold text-text">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="input py-3 @error('email') input-error @enderror"
                            placeholder="you@example.com"
                        >
                        @error('email')<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-semibold text-text">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="input py-3 @error('password') input-error @enderror"
                            placeholder="Enter your password"
                        >
                        @error('password')<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label for="remember" class="inline-flex items-center gap-2 text-sm text-text-muted">
                            <input id="remember" name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/40">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link text-sm">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </section>
    
    @if (Route::has('register'))
        <div class="mt-6 text-center text-sm text-text-muted">
            Need an account?
            <a href="{{ route('register') }}" class="link font-semibold">Create one</a>
        </div>
    @endif
@endsection
