@extends('frontend.layouts.app')

@section('title', config('app.name') . ' - Home')

@section('content')
    <div class="section-stack">
    <section class="content-section relative overflow-hidden">
        <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-indigo-100 blur-2xl"></div>
        <div class="absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-accent-100 blur-2xl"></div>

        <div class="relative grid gap-8 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="mb-3 inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-700">
                    Modern booking platform
                </p>
                <h1 class="text-display-md text-text">Book trusted services in minutes, not hours.</h1>
                <p class="mt-4 max-w-xl text-body text-text-muted">
                    Discover services, pick your preferred staff, and secure available time slots with a clean scheduling experience.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <x-button href="{{ route('frontend.book') }}">Book appointment</x-button>
                    <x-button variant="outline" href="{{ route('frontend.services') }}">Browse services</x-button>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 shadow-sm ring-1 ring-black/5">
                <p class="text-small text-text-muted">Trusted by customers</p>
                <dl class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-text-subtle">Bookings completed</dt>
                        <dd class="mt-1 text-h2 text-text">1.2k+</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-text-subtle">Avg. rating</dt>
                        <dd class="mt-1 text-h2 text-text">4.9/5</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-text-subtle">Service providers</dt>
                        <dd class="mt-1 text-h2 text-text">80+</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-text-subtle">Cancellation flow</dt>
                        <dd class="mt-1 text-h2 text-text">1 click</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <section class="content-section-alt section-divider">
        <div class="mb-5 flex items-end justify-between gap-3">
            <div>
                <h2 class="text-h2 text-text">Services highlight</h2>
                <p class="mt-1 text-small text-text-muted">Popular options customers book the most.</p>
            </div>
            <x-button variant="outline" href="{{ route('frontend.services') }}">View all</x-button>
        </div>
        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
            @forelse($featuredServices as $service)
                <article class="service-card">
                    <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}" class="service-card-media">
                        @if (service_image_url($service->image_path))
                            <img src="{{ service_image_url($service->image_path) }}" alt="" class="h-40 sm:h-44">
                        @else
                            <div class="flex h-40 items-center justify-center text-sm text-text-muted sm:h-44">No image</div>
                        @endif
                    </a>
                    <div class="service-card-body">
                        <h3 class="service-card-title text-h3">
                            <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}">{{ $service->name }}</a>
                        </h3>
                        <p class="service-meta">{{ $service->duration }} {{ __('minutes') }}</p>
                        <div class="service-price mt-auto">
                            <span class="service-price-label">{{ __('Price') }}</span>
                            <span class="service-price-amount">${{ number_format((float) $service->price, 2) }}</span>
                        </div>
                        <div class="service-card-actions">
                            <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}" class="btn-secondary w-full justify-center">{{ __('View details') }}</a>
                        </div>
                    </div>
                </article>
            @empty
                <article class="rounded-2xl border border-gray-200 bg-white p-6 text-text-muted shadow-sm">No services found yet.</article>
            @endforelse
        </div>
    </section>

    <section class="content-section section-divider">
        <h2 class="text-h2 text-text">How it works</h2>
        <p class="mt-1 text-small text-text-muted">Simple steps from discovery to confirmation.</p>
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Step 01</p>
                <h3 class="mt-2 text-h3 text-text">Choose service</h3>
                <p class="mt-2 text-small text-text-muted">Browse services and compare duration and pricing.</p>
            </article>
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Step 02</p>
                <h3 class="mt-2 text-h3 text-text">Pick a slot</h3>
                <p class="mt-2 text-small text-text-muted">Select a staff member, date, and available time slot.</p>
            </article>
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Step 03</p>
                <h3 class="mt-2 text-h3 text-text">Confirm booking</h3>
                <p class="mt-2 text-small text-text-muted">Track status, invoices, and updates from your dashboard.</p>
            </article>
        </div>
    </section>

    <section class="content-section-alt section-divider">
        <h2 class="text-h2 text-text">Testimonials</h2>
        <p class="mt-1 text-small text-text-muted">What our users say (dummy content).</p>
        <div class="mt-5 grid gap-4 lg:grid-cols-3">
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-small text-text-muted">"The booking flow is super smooth and saves our team hours every week."</p>
                <p class="mt-4 text-sm font-semibold text-text">Ava Patel</p>
                <p class="text-xs text-text-subtle">Operations Manager</p>
            </article>
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-small text-text-muted">"Clean UI, reliable slots, and easy rescheduling. Exactly what we needed."</p>
                <p class="mt-4 text-sm font-semibold text-text">Noah Wilson</p>
                <p class="text-xs text-text-subtle">Studio Owner</p>
            </article>
            <article class="rounded-2xl border border-border bg-white p-5 shadow-card">
                <p class="text-small text-text-muted">"Our customers love how fast they can find and book the right service."</p>
                <p class="mt-4 text-sm font-semibold text-text">Sophia Lee</p>
                <p class="text-xs text-text-subtle">Customer Success Lead</p>
            </article>
        </div>
    </section>

    <section class="content-section section-divider">
        <div class="rounded-3xl border border-indigo-100 bg-indigo-600 px-6 py-10 text-white shadow-soft sm:px-10">
            <h2 class="text-h2 text-white">Ready to simplify your bookings?</h2>
            <p class="mt-2 max-w-2xl text-sm text-indigo-100">Start with your next appointment in less than a minute and manage everything from one place.</p>
            <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm sm:inline-block">
                <div class="flex flex-wrap gap-3">
                    <x-button href="{{ route('frontend.book') }}">Get started</x-button>
                    <x-button variant="secondary" href="{{ route('frontend.services') }}">Explore services</x-button>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
