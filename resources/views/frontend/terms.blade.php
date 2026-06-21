@extends('layouts.guest')

@section('title', __('Terms & Conditions - ' . config('app.name')))

@section('content')
    <article class="space-y-12 max-w-4xl mx-auto">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                Legal
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                Terms & Conditions
            </h1>
            <p class="text-xs text-slate-500">Last updated: May 25, 2026</p>
        </div>

        <div class="card space-y-6 text-sm text-slate-400 leading-relaxed font-sans">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">1. Agreement to Terms</h2>
                <p>
                    By creating an account, reserving appointments, or utilizing scheduling assets, you agree to comply with and be bound by these Terms & Conditions.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">2. Booking Rules</h2>
                <p>
                    All booking reservations are subject to availability. Vetted professionals declare their calendar hours dynamically, and the system coordinates slot bookings. Cancellations must be submitted through your user dashboard.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">3. Fees and Billing</h2>
                <p>
                    You agree to pay all service fees as stated in the services catalog. Payments are processed securely, and itemized invoice receipts will be distributed directly to your dashboard upon session confirmation.
                </p>
            </section>
        </div>
    </article>
@endsection
