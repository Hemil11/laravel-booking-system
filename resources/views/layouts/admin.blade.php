@extends('layouts.app')

@section('layout')
    <div class="min-h-screen bg-gradient-to-b from-background via-background to-slate-100/60">
        <header class="sticky top-0 z-40 border-b border-border/80 bg-background-elevated/90 backdrop-blur">
            <div class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-sm font-semibold text-white shadow-soft">A</a>
                    <div>
                        <p class="text-sm font-semibold text-text">{{ config('app.name') }} Admin</p>
                        <p class="text-xs text-text-subtle">SaaS booking control panel</p>
                    </div>
                </div>

                @auth
                    <details class="group relative">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-xl border border-border bg-white px-3 py-2 text-sm font-medium text-text shadow-sm hover:bg-background-muted">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">
                                {{ strtoupper(substr((string) auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-text-subtle transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-44 rounded-xl border border-border bg-background-elevated p-1 shadow-soft">
                            <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-text hover:bg-background-muted">Profile</a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-danger hover:bg-red-50">Log out</button>
                            </form>
                        </div>
                    </details>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Log in</a>
                @endauth
            </div>
        </header>

        <div class="mx-auto grid w-full max-w-6xl grid-cols-1 gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[240px_minmax(0,1fr)] lg:px-8 lg:py-8">
            <aside class="rounded-2xl border border-border bg-background-elevated p-6 shadow-soft lg:sticky lg:top-24 lg:h-fit">
                <p class="mb-4 text-xs font-semibold uppercase tracking-wide text-text-subtle">Workspace</p>
                <nav class="space-y-2">
                    @php
                        $linkClass = 'block rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-text hover:border-border hover:bg-background-muted';
                    @endphp
                    <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass }}">Dashboard</a>
                    <a href="{{ route('services.index') }}" class="{{ $linkClass }}">Services</a>
                    <a href="{{ route('staff.index') }}" class="{{ $linkClass }}">Staff</a>
                    <a href="{{ route('bookings.index') }}" class="{{ $linkClass }}">Bookings</a>
                    <a href="{{ Route::has('invoices.index') ? route('invoices.index') : route('bookings.index') }}" class="{{ $linkClass }}">Invoices</a>
                    @if (Route::has('admin.reports'))
                        <a href="{{ route('admin.reports') }}" class="{{ $linkClass }}">Reports</a>
                    @endif
                </nav>
            </aside>

            <main class="space-y-8 rounded-2xl border border-border bg-background-elevated p-6 shadow-soft lg:p-8">
                @if (session('status'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
@endsection
