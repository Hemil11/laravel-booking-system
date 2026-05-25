@extends('layouts.guest')

@section('title', __('Frequently Asked Questions - ' . config('app.name')))

@section('content')
    <article class="space-y-12">
        <!-- Title Header Banner -->
        <div class="relative overflow-hidden rounded-3xl border border-white/5 bg-white/5 p-8 sm:p-12 shadow-2xl">
            <div class="absolute -right-24 -top-24 h-52 w-52 rounded-full bg-brand-500/10 blur-[80px] pointer-events-none"></div>
            <div class="relative max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    Quick Answers
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                    Frequently Asked Questions
                </h1>
                <p class="text-base text-slate-400 max-w-xl leading-relaxed">
                    Have questions? We have answers. Find resolutions to common inquiries about booking, billing, and accounts below.
                </p>
            </div>
        </div>

        <!-- Section Navigation Pills -->
        <div class="flex flex-wrap gap-2.5">
            <a href="#booking-scheduling" class="px-5 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white">
                Booking & Scheduling
            </a>
            <a href="#payments-billing" class="px-5 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white">
                Payments & Billing
            </a>
            <a href="#account-security" class="px-5 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white">
                Account & Security
            </a>
        </div>

        <!-- FAQ Sections -->
        <div class="space-y-10">
            <!-- Section 1: Booking & Scheduling -->
            <section id="booking-scheduling" class="card faq-accordion space-y-6">
                <h2 class="text-xl font-bold text-white font-display border-b border-white/5 pb-3">Booking & Scheduling</h2>
                <div class="space-y-4">
                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>How do I book an appointment?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            Simply head to our <a href="{{ route('frontend.book') }}" class="link">Book Appointment</a> page, choose a service from the interactive catalog, select a vetted team member, pick a date on the live calendar dashboard, and claim an available time slot.
                        </p>
                    </details>

                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>Can I reschedule or cancel my appointment?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            Yes! Authenticated users can log in, access their personal dashboard via the "My Bookings" page, select the specific booking session, and click "Cancel" or choose a new available timeline.
                        </p>
                    </details>

                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>What happens if a service provider cancels?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            In the rare event that a professional needs to cancel, you will receive an automatic email and SMS alert. Your scheduling token will be released, and you can immediately choose another slot or request a refund.
                        </p>
                    </details>
                </div>
            </section>

            <!-- Section 2: Payments & Billing -->
            <section id="payments-billing" class="card faq-accordion space-y-6">
                <h2 class="text-xl font-bold text-white font-display border-b border-white/5 pb-3">Payments & Billing</h2>
                <div class="space-y-4">
                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>What payment methods do you accept?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            We accept all major international credit/debit cards (Visa, Mastercard, American Express), Apple Pay, Google Pay, and regional bank transfers processed securely through Stripe.
                        </p>
                    </details>

                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>Do you offer refunds?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            Yes, cancellations requested at least 24 hours prior to the scheduled session are eligible for a full refund. Please read our <a href="{{ route('frontend.refund') }}" class="link">Refund Policy</a> for complete details.
                        </p>
                    </details>

                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>How do I download my payment invoice?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            Once payment is finalized, your tax invoice is generated automatically. You can view, print, or download the official PDF from the invoice details screen in your dashboard.
                        </p>
                    </details>
                </div>
            </section>

            <!-- Section 3: Account & Security -->
            <section id="account-security" class="card faq-accordion space-y-6">
                <h2 class="text-xl font-bold text-white font-display border-b border-white/5 pb-3">Account & Security</h2>
                <div class="space-y-4">
                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>How do I update my profile details?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            Log in and head to your account settings section. From there, you can edit your profile photo, display name, contact phone number, and timezone preferences.
                        </p>
                    </details>

                    <details class="group border-b border-white/5 pb-4 last:border-0 last:pb-0">
                        <summary class="flex justify-between items-center font-semibold text-white cursor-pointer list-none select-none hover:text-brand-400 transition-colors">
                            <span>How can I delete my account data?</span>
                            <span class="transition group-open:rotate-180 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed font-sans">
                            We support full GDPR/CCPA privacy rights. You can submit an automated deletion ticket directly from the <a href="{{ route('frontend.data-deletion') }}" class="link">Data Deletion Request</a> page.
                        </p>
                    </details>
                </div>
            </section>
        </div>
    </article>
@endsection
