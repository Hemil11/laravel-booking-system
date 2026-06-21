@extends('layouts.guest')

@section('title', __('Privacy Policy - ' . config('app.name')))

@section('content')
    <article class="space-y-12 max-w-4xl mx-auto">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                Legal
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                Privacy Policy
            </h1>
            <p class="text-xs text-slate-500">Last updated: May 25, 2026</p>
        </div>

        <div class="card space-y-6 text-sm text-slate-400 leading-relaxed font-sans">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">1. Information We Collect</h2>
                <p>
                    We collect personal information that you provide to us directly when creating an account, reserving service appointments, or submitting inquiries. This may include your full name, email address, payment credentials, and session booking notes.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">2. How We Use Your Data</h2>
                <p>
                    Your data is primarily used to secure session reservations with our vetted professionals, process payments, compile tax invoices, and notify you of calendar schedule updates or modifications.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">3. Information Sharing</h2>
                <p>
                    We do not sell your personal data. We share details only with selected service providers (vetted staff members) as necessary to complete appointment bookings and facilitate payment verification.
                </p>
            </section>
        </div>
    </article>
@endsection
