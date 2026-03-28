@extends('layouts.app')

@section('layout')
    <div class="min-h-screen bg-white text-text">
        <header class="sticky top-0 z-50 border-b border-border/70 bg-white/80 shadow-[0_6px_24px_rgba(15,23,42,0.06)] backdrop-blur-xl">
            <div class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('frontend.home') }}" class="inline-flex items-center gap-2 text-base font-semibold text-text">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-xs font-bold text-white">B</span>
                    {{ config('app.name') }}
                </a>

                @php
                    $navLinkBase = 'rounded-lg px-3 py-2 text-sm font-medium transition';
                @endphp

                <nav class="hidden items-center gap-2 lg:gap-3 md:flex">
                    <a href="{{ route('frontend.home') }}" class="{{ $navLinkBase }} {{ request()->routeIs('frontend.home') ? 'bg-brand-50 text-brand-700' : 'text-text-muted hover:bg-background-muted hover:text-brand-700' }}">Home</a>
                    <a href="{{ route('frontend.services') }}" class="{{ $navLinkBase }} {{ request()->routeIs('frontend.services', 'frontend.services.show') ? 'bg-brand-50 text-brand-700' : 'text-text-muted hover:bg-background-muted hover:text-brand-700' }}">Services</a>
                    <a href="{{ route('frontend.book') }}" class="{{ $navLinkBase }} {{ request()->routeIs('frontend.book') ? 'bg-brand-50 text-brand-700' : 'text-text-muted hover:bg-background-muted hover:text-brand-700' }}">Book appointment</a>
                    <a href="{{ route('frontend.contact') }}" class="{{ $navLinkBase }} {{ request()->routeIs('frontend.contact') ? 'bg-brand-50 text-brand-700' : 'text-text-muted hover:bg-background-muted hover:text-brand-700' }}">Contact</a>
                </nav>

                <div class="hidden items-center gap-2 md:flex">
                    @auth
                        <a href="{{ route('bookings.index') }}" class="btn-secondary">My bookings</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Log in</a>
                    @endauth
                </div>

                <details class="relative md:hidden">
                    <summary class="inline-flex cursor-pointer list-none items-center rounded-lg border border-border bg-white p-2 text-text shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 100 2h12a1 1 0 100-2H4z" clip-rule="evenodd" />
                        </svg>
                    </summary>
                    <div class="absolute right-0 mt-2 w-52 rounded-xl border border-border bg-white p-2 shadow-soft">
                        <a href="{{ route('frontend.home') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('frontend.home') ? 'bg-brand-50 font-medium text-brand-700' : 'text-text hover:bg-background-muted' }}">Home</a>
                        <a href="{{ route('frontend.services') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('frontend.services', 'frontend.services.show') ? 'bg-brand-50 font-medium text-brand-700' : 'text-text hover:bg-background-muted' }}">Services</a>
                        <a href="{{ route('frontend.book') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('frontend.book') ? 'bg-brand-50 font-medium text-brand-700' : 'text-text hover:bg-background-muted' }}">Book appointment</a>
                        <a href="{{ route('frontend.contact') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('frontend.contact') ? 'bg-brand-50 font-medium text-brand-700' : 'text-text hover:bg-background-muted' }}">Contact</a>
                        <div class="mt-1 border-t border-border pt-2">
                            @auth
                                <a href="{{ route('bookings.index') }}" class="block rounded-lg px-3 py-2 text-sm text-text hover:bg-background-muted">My bookings</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary w-full justify-center">Log in</a>
                            @endauth
                        </div>
                    </div>
                </details>
            </div>
        </header>

        <main class="page-container py-12 lg:py-14">
            @if (session('status'))
                <div class="mb-8 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="mt-16 border-t border-gray-800 bg-gray-900 text-gray-300">
            <div class="mx-auto grid w-full max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:px-8 md:grid-cols-3">
                <div class="md:col-span-1">
                    <h3 class="mb-3 text-sm font-semibold text-gray-200">About</h3>
                    <div class="mb-3 inline-flex items-center gap-2 text-base font-semibold text-gray-100">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-xs font-bold text-white">B</span>
                        {{ config('app.name') }}
                    </div>
                    <p class="max-w-sm text-sm text-gray-400">
                        Modern SaaS booking platform for seamless scheduling and service management.
                    </p>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-semibold text-gray-200">Product</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('frontend.services') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                Services
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.book') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                Book appointment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.contact') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-semibold text-gray-200">Account</h3>
                    <ul class="space-y-2 text-sm">
                        @auth
                            <li>
                                <a href="{{ route('bookings.index') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                    My bookings
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                    Log in
                                </a>
                            </li>
                        @endauth

                        <li>
                            <a href="{{ route('frontend.home') }}" class="inline-flex w-full items-center rounded-lg px-2 py-1 text-gray-300 transition hover:bg-gray-800 hover:text-gray-100">
                                Home
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800">
                <div class="mx-auto w-full max-w-6xl px-4 py-5 text-xs text-gray-500 sm:px-6 lg:px-8">
                    {{ now()->year }} {{ config('app.name') }}. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
@endsection
