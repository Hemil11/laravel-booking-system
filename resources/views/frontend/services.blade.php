@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')
    <section class="content-section">
        <div class="mb-6">
            <h1 class="text-h1 text-text">Services listing</h1>
            <p class="mt-2 text-small text-text-muted">Compare duration and pricing, then continue to appointment booking.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <article class="service-card">
                    <h3 class="text-h3 text-text">{{ $service->name }}</h3>
                    <p class="service-meta">{{ $service->duration }} minutes</p>
                    <p class="service-price">${{ number_format((float) $service->price, 2) }}</p>
                    <a href="{{ route('frontend.book') }}" class="service-button">Book now</a>
                </article>
            @empty
                <article class="rounded-2xl border border-border bg-background-elevated p-6 text-text-muted shadow-soft">
                    No services currently available.
                </article>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $services->links() }}
        </div>
    </section>
@endsection
