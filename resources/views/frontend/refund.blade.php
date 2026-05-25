@extends('layouts.guest')

@section('title', __('Refund Policy - ' . config('app.name')))

@section('content')
    <article class="space-y-12 max-w-4xl mx-auto">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                Legal
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                Refund Policy
            </h1>
            <p class="text-xs text-slate-500">Last updated: May 25, 2026</p>
        </div>

        <div class="card space-y-6 text-sm text-slate-400 leading-relaxed font-sans">
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">1. Cancellation Timelines</h2>
                <p>
                    We offer a flexible cancellation model. If you cancel a reserved booking session more than 24 hours prior to the scheduled start time, you are entitled to a full refund of any prepaid session fees.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">2. Late Cancellations</h2>
                <p>
                    Cancellations submitted less than 24 hours prior to the scheduled session start time may be subject to a late cancellation fee equal to 50% of the session pricing value, distributed directly to the professional to support their lost calendar slot.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-lg font-bold text-white font-display">3. Processing Times</h2>
                <p>
                    Approved refund requests are processed immediately. Funds are returned directly to the original payment method and will reflect on bank statements within 5 to 10 business days.
                </p>
            </section>
        </div>
    </article>
@endsection
