@extends('layouts.app')

@section('layout')
    <div class="flex min-h-screen flex-col bg-gray-100 text-text">
        <header class="nav-shell">
            <div class="nav-inner">
                <a href="{{ route('frontend.home') }}" class="nav-brand">
                    <span class="nav-brand-mark">B</span>
                    <span>{{ config('app.name') }}</span>
                </a>

                <nav class="nav-track" aria-label="Main navigation">
                    <a
                        href="{{ route('frontend.home') }}"
                        class="{{ request()->routeIs('frontend.home') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.home')) aria-current="page" @endif
                    >{{ __('Home') }}</a>
                    <a
                        href="{{ route('frontend.services') }}"
                        class="{{ request()->routeIs('frontend.services', 'frontend.services.show') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.services', 'frontend.services.show')) aria-current="page" @endif
                    >{{ __('Services') }}</a>
                    <a
                        href="{{ route('frontend.book') }}"
                        class="{{ request()->routeIs('frontend.book') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.book')) aria-current="page" @endif
                    >{{ __('Book appointment') }}</a>
                    <a
                        href="{{ route('frontend.contact') }}"
                        class="{{ request()->routeIs('frontend.contact') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.contact')) aria-current="page" @endif
                    >{{ __('Contact') }}</a>
                </nav>

                <div class="nav-actions">
                    @auth
                        <a href="{{ route('bookings.index') }}" class="btn-secondary">{{ __('My bookings') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">{{ __('Log in') }}</a>
                    @endauth
                </div>

                <details class="relative md:hidden">
                    <summary class="nav-mobile-trigger" aria-label="{{ __('Open menu') }}">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 100 2h12a1 1 0 100-2H4z" clip-rule="evenodd" />
                        </svg>
                    </summary>
                    <div class="nav-mobile-panel" role="menu">
                        <a
                            href="{{ route('frontend.home') }}"
                            class="{{ request()->routeIs('frontend.home') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Home') }}</a>
                        <a
                            href="{{ route('frontend.services') }}"
                            class="{{ request()->routeIs('frontend.services', 'frontend.services.show') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Services') }}</a>
                        <a
                            href="{{ route('frontend.book') }}"
                            class="{{ request()->routeIs('frontend.book') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Book appointment') }}</a>
                        <a
                            href="{{ route('frontend.contact') }}"
                            class="{{ request()->routeIs('frontend.contact') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Contact') }}</a>
                        <div class="mt-2 border-t border-gray-200 pt-2">
                            @auth
                                <a href="{{ route('bookings.index') }}" class="nav-mobile-link" role="menuitem">{{ __('My bookings') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary mt-1 w-full justify-center" role="menuitem">{{ __('Log in') }}</a>
                            @endauth
                        </div>
                    </div>
                </details>
            </div>
        </header>

        <main class="page-container section-wrap flex-1 pb-14 sm:pb-16 lg:pb-20">
            @if (session('status'))
                <div class="alert-success mb-8" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-auto border-t-2 border-gray-800 bg-gray-900 text-gray-300 shadow-[0_-16px_48px_-12px_rgba(0,0,0,0.35)]">
            <div class="mx-auto w-full max-w-6xl px-4 pt-16 pb-12 sm:px-6 lg:px-8 lg:pt-20 lg:pb-14">
                <div class="grid gap-12 sm:grid-cols-2 sm:gap-x-10 sm:gap-y-14 lg:grid-cols-3 lg:gap-x-16">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <h2 class="footer-section-title">{{ __('About') }}</h2>
                        <div class="mb-5 inline-flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white shadow-lg shadow-indigo-950/40">B</span>
                            <span class="text-lg font-semibold text-white">{{ config('app.name') }}</span>
                        </div>
                        <p class="max-w-sm text-sm leading-relaxed text-gray-300">
                            {{ __('Modern SaaS booking platform for seamless scheduling and service management.') }}
                        </p>
                    </div>

                    <div>
                        <h2 class="footer-section-title">{{ __('Product') }}</h2>
                        <ul class="space-y-1 text-sm">
                            <li>
                                <a href="{{ route('frontend.services') }}" class="footer-link">{{ __('Services') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.book') }}" class="footer-link">{{ __('Book appointment') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.contact') }}" class="footer-link">{{ __('Contact') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="footer-section-title">{{ __('Account') }}</h2>
                        <ul class="space-y-1 text-sm">
                            @auth
                                <li>
                                    <a href="{{ route('bookings.index') }}" class="footer-link">{{ __('My bookings') }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="footer-link">{{ __('Log in') }}</a>
                                </li>
                            @endauth
                            <li>
                                <a href="{{ route('frontend.home') }}" class="footer-link">{{ __('Home') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 bg-gray-950">
                <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center text-xs text-gray-300 sm:px-6 sm:text-left lg:px-8">
                    &copy; {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                </div>
            </div>
        </footer>
    </div>
@endsection
