@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')
    <section class="content-section">
        <div class="mb-8">
            <h1 class="text-h1 text-text">Services</h1>
            <p class="mt-2 max-w-2xl text-small text-text-muted">Browse our catalog, compare duration and pricing, then open a service for full details or book an appointment.</p>
        </div>

        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
            @forelse($services as $service)
                <article class="service-card">
                    <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}" class="service-card-media">
                        @if ($service->image_path && ($img = service_image_url($service->image_path)))
                            <img src="{{ $img }}" alt="" class="aspect-[4/3]">
                        @else
                            <div class="flex aspect-[4/3] w-full items-center justify-center text-sm text-text-muted">
                                {{ __('No image') }}
                            </div>
                        @endif
                    </a>
                    <div class="service-card-body">
                        <h2 class="service-card-title">
                            <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}">{{ $service->name }}</a>
                        </h2>
                        <p class="service-card-desc">
                            {{ $service->description ?: __('Professional service tailored to your needs.') }}
                        </p>
                        <p class="service-meta">{{ $service->duration }} {{ __('min') }}</p>
                        <div class="service-price mt-5">
                            <span class="service-price-label">{{ __('Price') }}</span>
                            <span class="service-price-amount">${{ number_format((float) $service->price, 2) }}</span>
                        </div>
                        <div class="service-card-actions">
                            <a href="{{ route('frontend.services.show', ['id' => $service->id]) }}" class="btn-secondary min-w-0 flex-1 justify-center">
                                {{ __('View details') }}
                            </a>
                            <a href="{{ route('frontend.book', ['service' => $service->id]) }}" class="btn-primary min-w-0 flex-1 justify-center">
                                {{ __('Book now') }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <article class="rounded-2xl border border-gray-200 bg-white p-8 text-text-muted shadow-sm sm:col-span-2 lg:col-span-3">
                    No services currently available.
                </article>
            @endforelse
        </div>

        <x-pagination class="mt-10" :paginator="$services" />
    </section>
@endsection
