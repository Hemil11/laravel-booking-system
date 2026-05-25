@extends('layouts.app')

@section('layout')
    <div class="flex min-h-screen flex-col text-text">
        <!-- Scroll progress bar -->
        <div class="scroll-progress-bar" id="scroll-progress"></div>
        <!-- Floating Modern Glass Navbar -->
        <header class="nav-shell sticky top-0 z-50">
            <div class="nav-inner">
                <a href="{{ route('frontend.home') }}" class="nav-brand">
                    <span class="nav-brand-mark">
                        <svg class="h-4 w-4 fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 22h20L12 2zm0 3.8L18.4 19H5.6L12 5.8z"/>
                        </svg>
                    </span>
                    <span class="font-display font-bold tracking-tight text-white">{{ config('app.name') }}</span>
                </a>

                <nav class="nav-track" aria-label="{{ __('Main navigation') }}">
                    @if (request()->routeIs('frontend.home'))
                        <a href="#saas-hero-container" class="nav-link nav-link-active" data-section="saas-hero-container">{{ __('Home') }}</a>
                        <a href="#services-catalog" class="nav-link" data-section="services-catalog">{{ __('Services') }}</a>
                        <a href="#how-it-works" class="nav-link" data-section="how-it-works">{{ __('How It Works') }}</a>
                        <a href="#why-choose-us" class="nav-link" data-section="why-choose-us">{{ __('Why Choose Us') }}</a>
                        <a href="#reviews" class="nav-link" data-section="reviews">{{ __('Reviews') }}</a>
                    @else
                        <a href="{{ route('frontend.home') }}" class="nav-link">{{ __('Home') }}</a>
                        <a href="{{ route('frontend.home') }}#services-catalog" class="nav-link">{{ __('Services') }}</a>
                        <a href="{{ route('frontend.home') }}#how-it-works" class="nav-link">{{ __('How It Works') }}</a>
                        <a href="{{ route('frontend.home') }}#why-choose-us" class="nav-link">{{ __('Why Choose Us') }}</a>
                        <a href="{{ route('frontend.home') }}#reviews" class="nav-link">{{ __('Reviews') }}</a>
                    @endif
                    <a
                        href="{{ route('frontend.book') }}"
                        class="{{ request()->routeIs('frontend.book') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.book')) aria-current="page" @endif
                    >{{ __('Book Appointment') }}</a>
                    <a
                        href="{{ route('frontend.contact') }}"
                        class="{{ request()->routeIs('frontend.contact') ? 'nav-link nav-link-active' : 'nav-link' }}"
                        @if (request()->routeIs('frontend.contact')) aria-current="page" @endif
                    >{{ __('Contact') }}</a>
                </nav>

                <div class="nav-actions">
                    @auth
                        <a href="{{ route('bookings.index') }}" class="btn-secondary btn-magnetic">{{ __('My Bookings') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary btn-magnetic btn-glow">{{ __('Log In') }}</a>
                    @endauth
                </div>

                <details class="relative md:hidden">
                    <summary class="nav-mobile-trigger" aria-label="{{ __('Open menu') }}">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm1 4a1 1 0 100 2h12a1 1 0 100-2H4z" clip-rule="evenodd" />
                        </svg>
                    </summary>
                    <div class="nav-mobile-panel" role="menu">
                        @if (request()->routeIs('frontend.home'))
                            <a href="#saas-hero-container" class="nav-mobile-link nav-mobile-link-active" data-section="saas-hero-container" role="menuitem">{{ __('Home') }}</a>
                            <a href="#services-catalog" class="nav-mobile-link" data-section="services-catalog" role="menuitem">{{ __('Services') }}</a>
                            <a href="#how-it-works" class="nav-mobile-link" data-section="how-it-works" role="menuitem">{{ __('How It Works') }}</a>
                            <a href="#why-choose-us" class="nav-mobile-link" data-section="why-choose-us" role="menuitem">{{ __('Why Choose Us') }}</a>
                            <a href="#reviews" class="nav-mobile-link" data-section="reviews" role="menuitem">{{ __('Reviews') }}</a>
                        @else
                            <a href="{{ route('frontend.home') }}" class="nav-mobile-link" role="menuitem">{{ __('Home') }}</a>
                            <a href="{{ route('frontend.home') }}#services-catalog" class="nav-mobile-link" role="menuitem">{{ __('Services') }}</a>
                            <a href="{{ route('frontend.home') }}#how-it-works" class="nav-mobile-link" role="menuitem">{{ __('How It Works') }}</a>
                            <a href="{{ route('frontend.home') }}#why-choose-us" class="nav-mobile-link" role="menuitem">{{ __('Why Choose Us') }}</a>
                            <a href="{{ route('frontend.home') }}#reviews" class="nav-mobile-link" role="menuitem">{{ __('Reviews') }}</a>
                        @endif
                        <a
                            href="{{ route('frontend.book') }}"
                            class="{{ request()->routeIs('frontend.book') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Book Appointment') }}</a>
                        <a
                            href="{{ route('frontend.contact') }}"
                            class="{{ request()->routeIs('frontend.contact') ? 'nav-mobile-link nav-mobile-link-active' : 'nav-mobile-link' }}"
                            role="menuitem"
                        >{{ __('Contact') }}</a>
                        <div class="mt-2 border-t border-gray-100 pt-2">
                            @auth
                                <a href="{{ route('bookings.index') }}" class="nav-mobile-link" role="menuitem">{{ __('My Bookings') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary mt-1 w-full justify-center" role="menuitem">{{ __('Log In') }}</a>
                            @endauth
                        </div>
                    </div>
                </details>
            </div>
        </header>

        <!-- Page Content Area -->
        @hasSection('full_bleed')
            <div class="flex-1">
                @yield('full_bleed')
            </div>
        @else
            <main class="page-container section-wrap flex-1 pb-14 sm:pb-16 lg:pb-20">
                @if (session('status'))
                    <div class="alert-success mb-8" role="status">
                        <svg class="h-5 w-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        @endif

        <!-- Premium Footer Layout -->
        <footer class="relative z-10 mt-auto border-t border-slate-800 bg-[#0b0f19] text-gray-400 shadow-[0_-16px_48px_-12px_rgba(15,23,42,0.3)]">
            <div class="mx-auto w-full max-w-6xl px-4 pt-16 pb-12 sm:px-6 lg:px-8 lg:pt-20 lg:pb-14">
                <div class="grid gap-12 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 lg:gap-x-8">
                    <!-- Brand info -->
                    <div class="sm:col-span-2 lg:col-span-1">
                        <div class="mb-5 inline-flex items-center gap-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-600 to-brand-400 text-sm font-extrabold text-white shadow-lg">
                                <svg class="h-4 w-4 fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L2 22h20L12 2zm0 3.8L18.4 19H5.6L12 5.8z"/>
                                </svg>
                            </span>
                            <span class="text-lg font-bold tracking-tight text-white font-display">{{ config('app.name') }}</span>
                        </div>
                        <p class="max-w-sm text-sm leading-relaxed text-slate-400">
                            {{ __('An ultra-premium scheduling system crafted for modern service platforms, offering seamless online reservation workflows.') }}
                        </p>
                    </div>

                    <!-- Product -->
                    <div>
                        <h2 class="footer-section-title">{{ __('Product') }}</h2>
                        <ul class="space-y-1.5 text-sm">
                            <li>
                                <a href="{{ route('frontend.services') }}" class="footer-link">{{ __('Services') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.book') }}" class="footer-link">{{ __('Book Appointment') }}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div>
                        <h2 class="footer-section-title">{{ __('Company') }}</h2>
                        <ul class="space-y-1.5 text-sm">
                            <li>
                                <a href="{{ route('frontend.about') }}" class="footer-link">{{ __('About Us') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.careers') }}" class="footer-link">{{ __('Careers') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.contact') }}" class="footer-link">{{ __('Contact') }}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h2 class="footer-section-title">{{ __('Legal') }}</h2>
                        <ul class="space-y-1.5 text-sm">
                            <li>
                                <a href="{{ route('frontend.privacy') }}" class="footer-link">{{ __('Privacy Policy') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.terms') }}" class="footer-link">{{ __('Terms & Conditions') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.refund') }}" class="footer-link">{{ __('Refund Policy') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.data-deletion') }}" class="footer-link">{{ __('Data Deletion Request') }}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h2 class="footer-section-title">{{ __('Support') }}</h2>
                        <ul class="space-y-1.5 text-sm">
                            <li>
                                <a href="{{ route('frontend.help') }}" class="footer-link">{{ __('Help Center') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.faq') }}" class="footer-link">{{ __('FAQ') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.contact') }}" class="footer-link">{{ __('Support') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-900 bg-[#070a12]">
                <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center text-xs text-slate-500 sm:px-6 sm:text-left lg:px-8 flex flex-col sm:flex-row sm:justify-between gap-4">
                    <span>&copy; {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</span>
                    <span class="flex justify-center gap-4">
                        <a href="{{ route('frontend.privacy') }}" class="hover:text-slate-400">{{ __('Privacy Policy') }}</a>
                        <a href="{{ route('frontend.terms') }}" class="hover:text-slate-400">{{ __('Terms of Service') }}</a>
                    </span>
                </div>
            </div>
        </footer>

        <!-- Mobile Sticky CTA bar -->
        <div class="mobile-sticky-cta" id="mobile-sticky-cta">
            <div class="text-left">
                <span class="block text-[8px] font-bold uppercase text-slate-500 tracking-wider">Premium Spaces</span>
                <span class="text-sm font-bold text-white">Reserve Slot</span>
            </div>
            <a href="{{ route('frontend.book') }}" class="btn-primary btn-ripple bg-white text-slate-950 py-2.5 px-5 rounded-xl font-extrabold text-xs shadow-md active:scale-95 transition-all">
                Book Now
            </a>
        </div>

        <!-- Back to Top floating button -->
        <button type="button" id="back-to-top" class="back-to-top-btn" aria-label="{{ __('Back to top') }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </div>
@endsection
