@extends('layouts.guest')

@section('title', __('About Us - ' . config('app.name')))

@section('content')
    <article class="space-y-12">
        <!-- Title Header Banner -->
        <div class="relative overflow-hidden rounded-3xl border border-white/5 bg-white/5 p-8 sm:p-12 shadow-2xl">
            <div class="absolute -right-24 -top-24 h-52 w-52 rounded-full bg-brand-500/10 blur-[80px] pointer-events-none"></div>
            <div class="relative max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    Our Mission
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                    About {{ config('app.name') }}
                </h1>
                <p class="text-base text-slate-400 max-w-xl leading-relaxed">
                    We are dedicated to building a frictionless scheduling infrastructure to link customers with vetted service professionals instantly.
                </p>
            </div>
        </div>

        <!-- Cohesive Content sections inside premium card layers -->
        <div class="grid gap-8 md:grid-cols-2">
            <div class="card space-y-4">
                <h2 class="text-xl font-bold text-white font-display">Our Philosophy</h2>
                <p class="text-sm text-slate-400 leading-relaxed font-sans">
                    We believe that scheduling sessions should be as simple as sending a message. We have eliminated complicated calendars, time slot math, and administrative booking email cycles by designing a system that coordinates live availability databases in real time.
                </p>
            </div>

            <div class="card space-y-4">
                <h2 class="text-xl font-bold text-white font-display">Our Standards</h2>
                <p class="text-sm text-slate-400 leading-relaxed font-sans">
                    Every service professional hosted on our platform undergoes background screening and capability verification. We guarantee that your reserved slot is secured, confirmed, and supported by enterprise SLA standards.
                </p>
            </div>
        </div>
    </article>
@endsection
