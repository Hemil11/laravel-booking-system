@extends('frontend.layouts.app')

@section('title', $service->name)

@section('content')
    <section class="content-section">
        <nav class="mb-6 text-sm text-text-muted">
            <a href="{{ route('frontend.services') }}" class="font-medium text-brand-700 hover:underline">Services</a>
            <span class="mx-2 text-text-subtle" aria-hidden="true">/</span>
            <span class="text-text">{{ $service->name }}</span>
        </nav>

        <div class="overflow-hidden rounded-2xl border border-border/90 bg-background-elevated shadow-soft transition hover:shadow-lg">
            <div class="aspect-[4/3] w-full overflow-hidden bg-background-muted sm:aspect-[2/1] lg:max-h-[min(28rem,55vh)]">
                @if (service_image_url($service->image_path))
                    <img
                        src="{{ service_image_url($service->image_path) }}"
                        alt="{{ $service->name }}"
                        class="h-full w-full object-cover"
                    >
                @else
                    <div class="flex h-full min-h-[220px] items-center justify-center text-sm text-text-muted">
                        No image available
                    </div>
                @endif
            </div>

            <div class="space-y-6 p-6 sm:p-8 lg:p-10">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-text sm:text-4xl">{{ $service->name }}</h1>
                    @if ($service->description)
                        <p class="mt-4 max-w-3xl text-base leading-relaxed text-text-muted">{{ $service->description }}</p>
                    @endif
                </div>

                <div class="grid gap-4 border-t border-slate-100 pt-6 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-text-subtle">Duration</p>
                        <p class="mt-1 text-lg font-semibold text-text">{{ $service->duration }} minutes</p>
                    </div>
                    <div class="rounded-xl border border-brand-100 bg-brand-50/70 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-800">Price</p>
                        <p class="mt-1 text-2xl font-bold text-brand-700">${{ number_format((float) $service->price, 2) }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-border pt-6 sm:flex-row sm:flex-wrap">
                    <a href="{{ route('frontend.book', ['service' => $service->id]) }}" class="btn-primary w-full justify-center sm:w-auto">
                        Book now
                    </a>
                    <a href="{{ route('frontend.services') }}" class="btn-secondary w-full justify-center sm:w-auto">
                        All services
                    </a>
                </div>

                @auth
                    @if (auth()->user()?->hasPermission('manage_services'))
                        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                            <span class="font-semibold">Admin:</span>
                            <a href="{{ route('services.edit', $service) }}" class="ml-1 font-medium text-brand-700 underline hover:text-brand-800">Edit service</a>
                            <span class="text-text-subtle"> · </span>
                            <a href="{{ route('services.index') }}" class="font-medium text-brand-700 underline hover:text-brand-800">Manage catalog</a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </section>
@endsection
