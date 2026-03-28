@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')
    <section class="content-section">
        <div class="mb-8">
            <h1 class="text-h1 text-text">Services</h1>
            <p class="mt-2 max-w-2xl text-small text-text-muted">Browse our catalog, compare duration and pricing, then open a service for full details or book an appointment.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-border/90 bg-background-elevated shadow-soft transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <a href="{{ route('frontend.services.show', $service) }}" class="block overflow-hidden bg-background-muted">
                        @if ($service->image_path && ($img = service_image_url($service->image_path)))
                            <img
                                src="{{ $img }}"
                                alt=""
                                class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                            >
                        @else
                            <div class="flex aspect-[4/3] w-full items-center justify-center text-sm text-text-muted">
                                No image
                            </div>
                        @endif
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="text-lg font-semibold text-text">
                            <a href="{{ route('frontend.services.show', $service) }}" class="transition hover:text-brand-700">{{ $service->name }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-text-muted">
                            {{ $service->description ?: 'Professional service tailored to your needs.' }}
                        </p>
                        <p class="mt-4 text-xs text-text-subtle">{{ $service->duration }} min</p>
                        <p class="mt-1 text-xl font-bold text-text">${{ number_format((float) $service->price, 2) }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('frontend.services.show', $service) }}" class="btn-secondary flex-1 justify-center">
                                View details
                            </a>
                            <a href="{{ route('frontend.book', ['service' => $service->id]) }}" class="btn-primary flex-1 justify-center">
                                Book now
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <article class="rounded-2xl border border-border bg-background-elevated p-8 text-text-muted shadow-soft sm:col-span-2 lg:col-span-3">
                    No services currently available.
                </article>
            @endforelse
        </div>

        <x-pagination class="mt-10" :paginator="$services" />
    </section>
@endsection
