@extends('layouts.guest')

@section('title', __('Help Center - ' . config('app.name')))

@section('content')
    <article class="space-y-12">
        <!-- Title Header Banner -->
        <div class="relative overflow-hidden rounded-3xl border border-white/5 bg-white/5 p-8 sm:p-12 shadow-2xl">
            <div class="absolute -right-24 -top-24 h-52 w-52 rounded-full bg-brand-500/10 blur-[80px] pointer-events-none"></div>
            <div class="relative max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    Support Portal
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                    Help Center & Documentation
                </h1>
                <p class="text-base text-slate-400 max-w-xl leading-relaxed">
                    Find answers, explore product guides, or learn how to optimize your appointment scheduling workflows.
                </p>
            </div>
        </div>

        <!-- Help Categories Bento Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1: Booking & Reservations -->
            <div class="card space-y-4 flex flex-col justify-between">
                <div>
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 mb-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white font-display">Booking & Schedule</h2>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Learn how to book a session, check staff availability slots, reschedule existing appointments, and manage calendar invitations.
                    </p>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <a href="{{ route('frontend.faq') }}#booking-scheduling" class="text-xs font-bold text-brand-400 hover:text-brand-300 inline-flex items-center gap-1">
                        Read Articles <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Accounts & Security -->
            <div class="card space-y-4 flex flex-col justify-between">
                <div>
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 mb-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white font-display">Account & Settings</h2>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Update your password, manage profile settings, configure two-factor authentication, or request personal data deletion.
                    </p>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <a href="{{ route('frontend.faq') }}#account-security" class="text-xs font-bold text-brand-400 hover:text-brand-300 inline-flex items-center gap-1">
                        Read Articles <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Card 3: Payments & Billing -->
            <div class="card space-y-4 flex flex-col justify-between">
                <div>
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 mb-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white font-display">Billing & Invoices</h2>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Review mock payment steps, check invoice lists, understand refund conditions, and print PDF payment statements.
                    </p>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <a href="{{ route('frontend.faq') }}#payments-billing" class="text-xs font-bold text-brand-400 hover:text-brand-300 inline-flex items-center gap-1">
                        Read Articles <span>→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact CTA card banner -->
        <div class="card bg-[#0b0f19] border border-brand-500/10 p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <h3 class="text-xl font-bold text-white font-display">Still need help?</h3>
                <p class="text-sm text-slate-400 max-w-lg">
                    If you cannot find the answer to your question, our customer success team is available 24/7.
                </p>
            </div>
            <a href="{{ route('frontend.contact') }}" class="btn-primary shrink-0 px-6 py-3 rounded-xl font-bold text-slate-950 active:scale-[0.99] transition-transform">
                Submit Support Ticket
            </a>
        </div>
    </article>
@endsection
