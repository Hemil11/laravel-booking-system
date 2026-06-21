@extends('layouts.guest')

@section('title', __('Data Deletion Request - ' . config('app.name')))

@section('content')
    <article class="space-y-12 max-w-3xl mx-auto">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                Compliance
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-white font-display">
                Data Deletion Request
            </h1>
            <p class="text-xs text-slate-500">Request account deletion and data removal under GDPR/CCPA compliance guidelines.</p>
        </div>

        <div class="card space-y-6">
            <h2 class="text-xl font-bold text-white font-display">Data Removal Process</h2>
            
            <p class="text-sm text-slate-400 leading-relaxed">
                If you wish to terminate your account and remove all personal information (including names, booking schedules, invoices, and messaging logs) from our active database servers, please submit a request below.
            </p>

            <form action="{{ route('frontend.contact.submit') }}" method="post" class="space-y-4 pt-4 border-t border-white/5">
                @csrf
                <input type="hidden" name="name" value="{{ auth()->user()?->name ?? 'User Deletion Request' }}">
                <input type="hidden" name="email" value="{{ auth()->user()?->email ?? 'noreply@saas.test' }}">
                <input type="hidden" name="message" value="Account Data Deletion Request: GDPR/CCPA request to remove all personal database fields.">
                
                <div class="rounded-2xl border border-amber-500/30 bg-amber-500/10 p-4 text-xs text-amber-400">
                    <strong>Warning:</strong> This action is irreversible. All records, historical bookings, and receipts will be permanently destroyed.
                </div>

                <button type="submit" class="btn-danger w-full py-3.5 rounded-xl font-bold text-white shadow-md active:scale-[0.99]">
                    Submit Data Deletion Request
                </button>
            </form>
        </div>
    </article>
@endsection
