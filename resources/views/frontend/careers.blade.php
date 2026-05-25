@extends('layouts.guest')

@section('title', __('Careers - ' . config('app.name')))

@section('content')
    <article class="space-y-12">
        <div class="relative overflow-hidden rounded-3xl border border-white/5 bg-white/5 p-8 sm:p-12 shadow-2xl">
            <div class="absolute -right-24 -top-24 h-52 w-52 rounded-full bg-brand-500/10 blur-[80px] pointer-events-none"></div>
            <div class="relative max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    Join Us
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                    Careers at {{ config('app.name') }}
                </h1>
                <p class="text-base text-slate-400 max-w-xl leading-relaxed">
                    Shape the future of service scheduling. We are always searching for talented builders, designers, and thinkers.
                </p>
            </div>
        </div>

        <div class="card space-y-6">
            <h2 class="text-xl font-bold text-white font-display">Current Openings</h2>
            
            <div class="space-y-4 divide-y divide-white/5">
                <div class="pt-4 first:pt-0 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-white leading-none">Senior Full-Stack Engineer</h3>
                        <span class="inline-block text-[10px] font-semibold text-slate-500 mt-1.5">Remote · Engineering · Full-time</span>
                    </div>
                    <a href="{{ route('frontend.contact') }}" class="btn-secondary py-2 px-4 rounded-xl text-xs font-semibold">Apply</a>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-white leading-none">Senior Product Designer</h3>
                        <span class="inline-block text-[10px] font-semibold text-slate-500 mt-1.5">New York, NY · Design · Full-time</span>
                    </div>
                    <a href="{{ route('frontend.contact') }}" class="btn-secondary py-2 px-4 rounded-xl text-xs font-semibold">Apply</a>
                </div>
            </div>
        </div>
    </article>
@endsection
