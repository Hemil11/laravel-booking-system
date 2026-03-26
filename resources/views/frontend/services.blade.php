@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')
    <section class="section" style="padding-top:2rem;">
        <h1 class="section-title">Services listing</h1>
        <p style="margin:0 0 1rem; color:var(--muted);">Compare duration and pricing, then continue to appointment booking.</p>

        <div class="grid">
            @forelse($services as $service)
                <article class="card service-card">
                    <h3>{{ $service->name }}</h3>
                    <p class="service-meta">{{ $service->duration }} minutes</p>
                    <p style="margin:0.4rem 0 0.9rem;">${{ number_format((float) $service->price, 2) }}</p>
                    <a href="{{ route('frontend.book') }}" class="btn btn-outline">Book now</a>
                </article>
            @empty
                <article class="card">No services currently available.</article>
            @endforelse
        </div>

        <div style="margin-top:1rem;">
            {{ $services->links() }}
        </div>
    </section>
@endsection
