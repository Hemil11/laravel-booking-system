@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <section class="relative overflow-hidden rounded-3xl border border-border/80 bg-gradient-to-br from-brand-50 via-white to-slate-100 p-4 shadow-soft sm:p-6 lg:p-8">
        <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-brand-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-accent-200/40 blur-3xl"></div>

        <div class="relative grid gap-6 lg:grid-cols-2">
            <div class="hidden rounded-2xl border border-brand-100 bg-brand-600 p-8 text-white shadow-soft lg:block">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-100">Join today</p>
                <h1 class="mt-4 text-3xl font-bold leading-tight text-white">Book services and manage appointments in one place.</h1>
                <p class="mt-4 text-sm text-brand-100">
                    Create a free customer account to schedule visits, track bookings, and stay on top of your calendar.
                </p>
                <div class="mt-8 rounded-xl border border-brand-300/30 bg-white/10 p-4">
                    <p class="text-sm text-brand-50">Your data is protected with secure authentication and role-based access.</p>
                </div>
            </div>

            <div class="mx-auto w-full max-w-xl rounded-2xl border border-border bg-white p-6 shadow-soft sm:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-text">Create your account</h2>
                    <p class="mt-2 text-sm text-text-muted">Fill in your details to get started. It only takes a minute.</p>
                </div>

                <form method="post" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <x-form.input
                        name="name"
                        label="Name"
                        required
                        maxlength="255"
                        placeholder="Your full name"
                        autocomplete="name"
                        class="py-3"
                    />

                    <x-form.input
                        name="email"
                        label="Email"
                        type="email"
                        required
                        placeholder="you@example.com"
                        autocomplete="email"
                        class="py-3"
                    />

                    <x-form.input
                        name="password"
                        label="Password"
                        type="password"
                        required
                        placeholder="Choose a strong password"
                        autocomplete="new-password"
                        class="py-3"
                    />

                    <x-form.input
                        name="password_confirmation"
                        label="Confirm password"
                        type="password"
                        required
                        placeholder="Repeat your password"
                        autocomplete="new-password"
                        class="py-3"
                    />

                    <button type="submit" class="btn-primary w-full justify-center">
                        Create account
                    </button>
                </form>
            </div>
        </div>
    </section>

    <div class="mt-6 text-center text-sm text-text-muted">
        Already have an account?
        <a href="{{ route('login') }}" class="link font-semibold">Sign in</a>
    </div>
@endsection
