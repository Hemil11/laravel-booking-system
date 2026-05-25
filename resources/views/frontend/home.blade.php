@extends('layouts.guest')

@section('title', config('app.name') . ' - Premium Workspace & Studio Bookings')

@push('head')
<style>
    /* Premium subtle gradient background flow */
    .mesh-background {
        position: absolute;
        inset: 0;
        background-color: #030508;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.06) 0%, transparent 45%);
        opacity: 0.9;
        z-index: 0;
    }
</style>
@endpush

@section('full_bleed')
<div class="bg-[#030508] text-white overflow-hidden relative">
    
    <!-- Cinematic Background -->
    <div class="mesh-background"></div>

    <!-- 1. HERO SECTION -->
    <section class="relative pt-12 pb-10 page-container z-10" id="saas-hero-container">
        <div class="grid gap-8 lg:grid-cols-12 lg:items-center">
            
            <!-- Hero Left: Business Headline & Value Proposition -->
            <div class="lg:col-span-6 space-y-5 text-left">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-brand-300 backdrop-blur-xl">
                    <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                    Professional Booking Platform
                </div>

                <h1 class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl xl:text-6xl leading-[1.1] text-white animate-headline-reveal">
                    Book Premium <br>
                    <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-cyan-400 bg-clip-text text-transparent">Workspaces Instantly.</span>
                </h1>

                <p class="max-w-lg text-sm text-slate-400 leading-relaxed font-sans font-medium">
                    Secure vetted consultant rooms, audio/video production studios, and private meeting spaces. Browse real-time availability, lock in your calendar slot, and get instant booking confirmations.
                </p>

                <!-- Action CTAs -->
                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('frontend.book') }}" class="btn-primary btn-magnetic btn-glow bg-white text-slate-950 hover:bg-slate-100 border-none px-6 py-3.5 rounded-xl font-extrabold shadow-md active:scale-95 transition-all text-xs">
                        Book Appointment
                    </a>
                    <a href="#services-catalog" class="btn-secondary btn-magnetic bg-white/5 border-white/10 hover:border-white/20 text-white px-6 py-3.5 rounded-xl font-bold active:scale-95 transition-all text-xs">
                        Browse Services
                    </a>
                </div>

                <!-- Trust Badges & Metrics -->
                <div class="pt-4 border-t border-white/5 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-2">
                        <span class="h-5 w-5 rounded-md bg-green-500/10 flex items-center justify-center text-green-400 text-xs">✓</span>
                        <span class="text-xs text-slate-400">Over 5,000+ bookings confirmed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-5 w-5 rounded-md bg-green-500/10 flex items-center justify-center text-green-400 text-xs">✓</span>
                        <span class="text-xs text-slate-400">99.8% customer satisfaction rate</span>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Realistic Booking Widget Preview -->
            <div class="lg:col-span-6">
                <div class="relative w-full max-w-md mx-auto lg:max-w-none">
                    <!-- Glow Underlay -->
                    <div class="absolute -inset-2 rounded-3xl bg-gradient-to-tr from-brand-500 to-indigo-500 opacity-20 blur-xl"></div>
                    
                    <!-- Booking widget card layout -->
                    <div class="relative rounded-3xl border border-white/10 bg-[#070b16]/95 p-5 shadow-2xl backdrop-blur-2xl">
                        <div class="flex items-center justify-between border-b border-white/5 pb-3 mb-4">
                            <span class="text-xs font-bold text-white">Live Calendar Synchronization</span>
                            <span class="inline-flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                        </div>

                        <div class="space-y-4 text-left">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Selected Studio</label>
                                <div class="flex items-center justify-between rounded-xl bg-white/5 border border-white/5 p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="h-8 w-8 rounded-lg bg-brand-500/20 flex items-center justify-center text-xs font-bold text-brand-400">WS</span>
                                        <div>
                                            <span class="text-xs font-bold text-slate-200 block">Podcast Recording Suite</span>
                                            <span class="text-[10px] text-slate-500 block">Equipped with premium audio monitors</span>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-brand-400">$65.00/hr</span>
                                </div>
                            </div>

                            <!-- Calendar selector preview -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Select Date & Time</label>
                                <div class="grid grid-cols-4 gap-2">
                                    <div class="bg-white/5 border border-white/5 p-2 rounded-xl text-center">
                                        <span class="block text-[8px] text-slate-500 font-bold uppercase">Wed</span>
                                        <span class="text-xs font-bold text-slate-400">26</span>
                                    </div>
                                    <div class="bg-brand-600/90 border border-brand-500/50 p-2 rounded-xl text-center shadow-md shadow-brand-500/20">
                                        <span class="block text-[8px] text-brand-200 font-bold uppercase">Thu</span>
                                        <span class="text-xs font-bold text-white">27</span>
                                    </div>
                                    <div class="bg-white/5 border border-white/5 p-2 rounded-xl text-center">
                                        <span class="block text-[8px] text-slate-500 font-bold uppercase">Fri</span>
                                        <span class="text-xs font-bold text-slate-400">28</span>
                                    </div>
                                    <div class="bg-white/5 border border-white/5 p-2 rounded-xl text-center">
                                        <span class="block text-[8px] text-slate-500 font-bold uppercase">Sat</span>
                                        <span class="text-xs font-bold text-slate-400">29</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slot list preview -->
                            <div class="grid grid-cols-3 gap-2">
                                <span class="bg-white/5 border border-white/5 py-1.5 rounded-lg text-[10px] text-center font-semibold text-slate-400">09:00 AM</span>
                                <span class="bg-brand-500/10 border border-brand-500/30 py-1.5 rounded-lg text-[10px] text-center font-bold text-brand-400">01:00 PM</span>
                                <span class="bg-white/5 border border-white/5 py-1.5 rounded-lg text-[10px] text-center font-semibold text-slate-400">04:30 PM</span>
                            </div>

                            <a href="{{ route('frontend.book') }}" class="btn-primary w-full text-xs font-bold py-3 justify-center rounded-xl bg-white text-slate-950 hover:bg-slate-100 border-none transition-all mt-2 shadow-md">
                                Reserve Slot
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. TRUSTED BY CUSTOMERS -->
    <section class="border-y border-white/5 bg-white/[0.01] py-6 z-10 relative">
        <div class="page-container grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
            <div class="space-y-1">
                <span class="block text-2xl font-extrabold text-white tracking-tight">★ 4.9 / 5.0</span>
                <span class="text-xs text-slate-400">From 1,200+ Verified User Reviews</span>
            </div>
            <div class="space-y-1 border-y sm:border-y-0 sm:border-x border-white/5 py-4 sm:py-0">
                <span class="block text-2xl font-extrabold text-brand-400 tracking-tight">
                    <span class="stat-counter" data-counter-target="5000">0</span>+
                </span>
                <span class="text-xs text-slate-400">Appointments Completed Successfully</span>
            </div>
            <div class="space-y-1">
                <span class="block text-2xl font-extrabold text-white tracking-tight">
                    <span class="stat-counter" data-counter-target="50">0</span>+
                </span>
                <span class="text-xs text-slate-400">Active Professionals & Studio Spaces</span>
            </div>
        </div>
    </section>

    <!-- 3. FEATURED SERVICES -->
    <section class="py-12 page-container space-y-8 z-10 relative" id="services-catalog">
        <div class="text-left space-y-1.5 max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Book Instantly</span>
            <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight text-white">
                Available Booking Sessions
            </h2>
            <p class="text-slate-400 text-sm leading-relaxed">
                Choose the workspace or session type that fits your scheduling requirements. Select dates and reserve slots directly.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredServices as $service)
                <article class="card tilt-card flex flex-col justify-between group relative overflow-hidden border-white/5 hover:border-brand-500/30 transition-all duration-300" style="min-height: 320px;">
                    <div>
                        @if (service_image_url($service->image_path))
                            <div class="aspect-[16/9] w-full rounded-xl zoom-on-hover overflow-hidden border border-white/5 mb-3.5">
                                <img src="{{ service_image_url($service->image_path) }}" alt="{{ $service->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-103">
                            </div>
                        @else
                            <div class="aspect-[16/9] w-full rounded-xl bg-white/5 border border-white/5 flex items-center justify-center mb-3.5 text-slate-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        @endif

                        <div class="space-y-1 text-left">
                            <div class="flex items-center justify-between">
                                <span class="inline-block text-[9px] font-bold uppercase tracking-wider text-slate-500 bg-white/5 px-2.5 py-0.5 rounded-full border border-white/5">
                                    {{ $service->duration }} minutes
                                </span>
                                <span class="text-[10px] text-yellow-400 font-bold">★ 4.9</span>
                            </div>
                            <h3 class="text-base font-bold tracking-tight text-white group-hover:text-brand-400 transition-colors pt-1">
                                {{ $service->name }}
                            </h3>
                        </div>
                    </div>

                    <div class="mt-4 pt-3.5 border-t border-white/5 space-y-3">
                        <div class="flex items-center justify-between text-left">
                            <span class="text-[9px] text-slate-500 font-bold uppercase">Rate (Hourly)</span>
                            <span class="text-sm font-extrabold text-slate-200">${{ number_format((float) $service->price, 2) }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}" class="btn-secondary py-2 text-[10px] justify-center border-white/10 hover:border-white/20 rounded-lg text-white font-bold transition-all active:scale-[0.98]">
                                Specs
                            </a>
                            <a href="{{ route('frontend.book', ['service' => $service->id]) }}" class="btn-primary py-2 text-[10px] justify-center bg-white text-slate-950 rounded-lg font-extrabold shadow-md active:scale-[0.98] transition-all">
                                Book Slot
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full card text-center py-10 text-slate-500 font-sans text-xs">
                    No services configured. Please log in as admin to add workspaces.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. HOW BOOKING WORKS -->
    <section class="py-12 border-t border-white/5 bg-slate-950/20 z-10 relative" id="how-it-works">
        <div class="page-container space-y-8">
            <div class="text-left max-w-2xl space-y-1.5">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Process</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight text-white">How Booking Works</h2>
                <p class="text-slate-400 text-sm leading-relaxed">Secure your booking space within two minutes with our simplified reservation workflow.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3 reveal-stagger">
                <div class="card space-y-2.5 flex flex-col text-left reveal-fade">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-brand-500/20 text-brand-400 border border-brand-500/25 font-extrabold text-xs">01</span>
                    <h3 class="text-base font-bold text-white">Discover & Select</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-sans">
                        Browse through private consultant rooms, audio/video production spaces, or team offices in our catalog.
                    </p>
                </div>

                <div class="card space-y-2.5 flex flex-col text-left reveal-fade">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-500/20 text-indigo-400 border border-indigo-500/25 font-extrabold text-xs">02</span>
                    <h3 class="text-base font-bold text-white">Pick Open Slot</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-sans">
                        Check real-time calendar coordinates. Select your manager or team member and secure a vacant hour slot.
                    </p>
                </div>

                <div class="card space-y-2.5 flex flex-col text-left reveal-fade">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-green-500/20 text-green-400 border border-green-500/25 font-extrabold text-xs">03</span>
                    <h3 class="text-base font-bold text-white">Secure Receipt</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-sans">
                        Complete checkout secure steps. Invoices, confirmation tokens, and calendar invites are sent instantly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. WHY CUSTOMERS CHOOSE US (Guarantees) -->
    <section class="py-12 page-container space-y-8 z-10 relative" id="why-choose-us">
        <div class="text-left space-y-1.5 max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Guarantees</span>
            <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight text-white">Built for Reliability & Security</h2>
            <p class="text-slate-400 text-sm leading-relaxed">We provide a premium booking system configured with strict customer guarantees.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 reveal-stagger">
            <div class="card tilt-card p-5 space-y-2.5 text-left reveal-scale">
                <span class="h-7 w-7 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0 text-xs">✓</span>
                <h3 class="text-sm font-bold text-white">Transparent Pricing</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-sans">Fixed hourly rates for every workspace with absolutely no hidden setup fees or surprise surcharges.</p>
            </div>

            <div class="card tilt-card p-5 space-y-2.5 text-left reveal-scale">
                <span class="h-7 w-7 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0 text-xs">✓</span>
                <h3 class="text-sm font-bold text-white">Verified Professionals</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-sans">All hosted coordinators and staff undergo strict background checks and vetting procedures.</p>
            </div>

            <div class="card tilt-card p-5 space-y-2.5 text-left reveal-scale">
                <span class="h-7 w-7 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0 text-xs">✓</span>
                <h3 class="text-sm font-bold text-white">Secure Checkouts</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-sans">All transactions are heavily encrypted and processed directly via Stripe with PDF receipts generated.</p>
            </div>

            <div class="card tilt-card p-5 space-y-2.5 text-left reveal-scale">
                <span class="h-7 w-7 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400 shrink-0 text-xs">✓</span>
                <h3 class="text-sm font-bold text-white">Instant Confirmation</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-sans">Real-time calendar updates keep coordinators and clients synchronized, preventing double-bookings.</p>
            </div>
        </div>
    </section>

    <!-- 6. TESTIMONIALS -->
    <section class="py-12 border-t border-white/5 bg-slate-950/20 z-10 relative" id="reviews">
        <div class="page-container space-y-8">
            <div class="text-left space-y-1.5 max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Customer Reviews</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight text-white">Loved by Creators & Teams</h2>
                <p class="text-slate-400 text-sm leading-relaxed">Here is how professionals and workspace users review our booking operations.</p>
            </div>

            <div class="testimonial-carousel-container">
                <div class="testimonial-carousel-track">
                    <div class="testimonial-carousel-slide">
                        <blockquote class="card flex flex-col justify-between space-y-5 text-left h-full">
                            <p class="text-slate-300 text-xs italic leading-relaxed font-sans">
                                "The workspace was perfectly configured and ready right on schedule. Being able to reschedule directly from the dashboard was incredibly convenient when our presentation shifted."
                            </p>
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-full bg-brand-500/20 border border-brand-500/35 flex items-center justify-center font-bold text-xs text-brand-300 shrink-0">RC</div>
                                <div>
                                    <cite class="not-italic text-xs font-bold text-white block">Dr. Robert Chen</cite>
                                    <span class="text-[10px] text-slate-500 font-sans block">Consultant & Lecturer</span>
                                    <span class="text-[9px] text-yellow-400">★★★★★</span>
                                </div>
                            </div>
                        </blockquote>
                    </div>

                    <div class="testimonial-carousel-slide">
                        <blockquote class="card flex flex-col justify-between space-y-5 text-left h-full">
                            <p class="text-slate-300 text-xs italic leading-relaxed font-sans">
                                "We booked the production studio for our weekly podcast. The recording equipment is state-of-the-art, booking takes minutes, and Stripe invoice files are generated instantly."
                            </p>
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-full bg-cyan-500/20 border border-cyan-500/35 flex items-center justify-center font-bold text-xs text-cyan-300 shrink-0">MH</div>
                                <div>
                                    <cite class="not-italic text-xs font-bold text-white block">Marcus Harte</cite>
                                    <span class="text-[10px] text-slate-500 font-sans block">Podcast Director</span>
                                    <span class="text-[9px] text-yellow-400">★★★★★</span>
                                </div>
                            </div>
                        </blockquote>
                    </div>

                    <div class="testimonial-carousel-slide">
                        <blockquote class="card flex flex-col justify-between space-y-5 text-left h-full">
                            <p class="text-slate-300 text-xs italic leading-relaxed font-sans">
                                "We utilize these private offices for weekly client strategy sessions. The calendar API integration works flawlessly and verified staff details keep our team confident."
                            </p>
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-full bg-purple-500/20 border border-purple-500/35 flex items-center justify-center font-bold text-xs text-purple-300 shrink-0">SK</div>
                                <div>
                                    <cite class="not-italic text-xs font-bold text-white block">Sarah Kincaid</cite>
                                    <span class="text-[10px] text-slate-500 font-sans block">Creative Project Lead</span>
                                    <span class="text-[9px] text-yellow-400">★★★★★</span>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FAQ ACCORDION -->
    <section class="py-12 page-container space-y-8 z-10 relative">
        <div class="text-left space-y-1.5 max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-400">Support</span>
            <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight text-white">Frequently Asked Questions</h2>
            <p class="text-slate-400 text-sm leading-relaxed">Find quick answers to common questions about our booking rules and payment procedures.</p>
        </div>

        <div class="faq-accordion max-w-3xl mx-auto space-y-3">
            <details class="group rounded-2xl border border-white/5 bg-[#0d1324]/40 p-4 transition-all duration-200">
                <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-white list-none">
                    <span>What is the rescheduling policy?</span>
                    <span class="text-slate-400 transition-transform group-open:rotate-180">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </summary>
                <div class="faq-accordion-body mt-2.5 text-xs text-slate-400 leading-relaxed">
                    You can reschedule any workspace booking or appointment up to 24 hours prior to the start time directly from your user dashboard. Rescheduling is free of charge.
                </div>
            </details>

            <details class="group rounded-2xl border border-white/5 bg-[#0d1324]/40 p-4 transition-all duration-200">
                <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-white list-none">
                    <span>Are payments secure?</span>
                    <span class="text-slate-400 transition-transform group-open:rotate-180">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </summary>
                <div class="faq-accordion-body mt-2.5 text-xs text-slate-400 leading-relaxed">
                    Yes. All payments are encrypted and processed through Stripe, the global standard for secure transactions. We do not store your credit card information.
                </div>
            </details>

            <details class="group rounded-2xl border border-white/5 bg-[#0d1324]/40 p-4 transition-all duration-200">
                <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-white list-none">
                    <span>Can I cancel and get a full refund?</span>
                    <span class="text-slate-400 transition-transform group-open:rotate-180">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </summary>
                <div class="faq-accordion-body mt-2.5 text-xs text-slate-400 leading-relaxed">
                    Cancellations made more than 24 hours in advance qualify for a 100% refund returned to your original payment method. Cancellations within 24 hours are non-refundable.
                </div>
            </details>
        </div>
    </section>

    <!-- 8. FINAL CONVERSION CTA -->
    <section class="py-10 page-container z-10 relative">
        <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-tr from-brand-950/45 via-[#0b0e1a] to-indigo-950/45 border border-white/10 px-6 py-10 text-center shadow-2xl">
            <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-brand-500/5 blur-[80px] pointer-events-none"></div>
            <div class="absolute -left-24 -bottom-24 h-64 w-64 rounded-full bg-indigo-500/5 blur-[80px] pointer-events-none"></div>
            
            <div class="relative max-w-2xl mx-auto space-y-4 z-10">
                <span class="inline-flex items-center gap-1 rounded-full bg-white/5 border border-white/10 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-widest text-brand-300">
                    Secure Current Rates
                </span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-white tracking-tight leading-tight">
                    Reserve Your Workspace Today.
                </h2>
                <p class="text-slate-400 text-xs max-w-md mx-auto leading-relaxed font-sans">
                    Complete your scheduling details in under 2 minutes. Secure confirmations and calendar updates are dispatched instantly.
                </p>
                <div class="flex flex-wrap justify-center gap-3 pt-2">
                    <a href="{{ route('frontend.book') }}" class="btn-primary bg-white text-slate-950 hover:bg-slate-100 border-none px-6 py-3 rounded-lg shadow-md active:scale-95 transition-all font-bold text-xs">
                        Book Your Spot Now
                    </a>
                    <a href="#services-catalog" class="btn-secondary bg-white/5 border-white/10 hover:border-white/20 text-white px-6 py-3 rounded-lg active:scale-95 transition-all font-bold text-xs">
                        Browse Full Catalog
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
