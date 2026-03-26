@extends('frontend.layouts.app')

@section('title', config('app.name') . ' - Home')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <h1>Book trusted services in a few clicks.</h1>
                <p>
                    Discover quality services, choose available time slots, and manage your appointments from one clean booking platform.
                </p>
                <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
                    <a href="{{ route('frontend.book') }}" class="btn btn-primary">Book appointment</a>
                    <a href="{{ route('frontend.services') }}" class="btn btn-outline">Browse services</a>
                </div>
            </div>
            <div class="hero-card">
                <p style="margin:0; color:var(--muted); font-size:0.92rem;">Fast facts</p>
                <h3 style="margin:0.35rem 0 0.7rem;">Why customers love this platform</h3>
                <ul style="margin:0; padding-left:1rem; color:#334155;">
                    <li>Real-time slot availability</li>
                    <li>Simple confirm/cancel flow</li>
                    <li>Invoice + mock payment support</li>
                    <li>Mobile-friendly responsive design</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Featured services</h2>
        <div class="grid">
            @forelse($featuredServices as $service)
                <article class="card service-card">
                    <h3>{{ $service->name }}</h3>
                    <p class="service-meta">{{ $service->duration }} minutes</p>
                    <p style="margin:0.4rem 0 0.9rem;">${{ number_format((float) $service->price, 2) }}</p>
                    <a href="{{ route('frontend.book') }}" class="btn btn-outline">Book this service</a>
                </article>
            @empty
                <article class="card">No services found yet.</article>
            @endforelse
        </div>
    </section>
@endsection
