@extends('frontend.layouts.app')

@section('title', $service->name)

@section('content')
    <section class="content-section">
        <nav class="mb-6 text-sm text-text-muted" aria-label="{{ __('Breadcrumb') }}">
            <a href="{{ route('frontend.home') }}" class="font-medium text-indigo-700 transition hover:text-indigo-800 hover:underline">{{ __('Home') }}</a>
            <span class="mx-2 text-text-subtle" aria-hidden="true">/</span>
            <a href="{{ route('frontend.services') }}" class="font-medium text-indigo-700 transition hover:text-indigo-800 hover:underline">{{ __('Services') }}</a>
            <span class="mx-2 text-text-subtle" aria-hidden="true">/</span>
            <span class="text-text">{{ $service->name }}</span>
        </nav>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-start lg:gap-10 xl:gap-14">
            {{-- Large image --}}
            <div class="lg:col-span-7">
                <figure class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 shadow-md ring-1 ring-black/5 lg:sticky lg:top-24">
                    <div
                        class="relative aspect-[16/10] w-full min-h-[14rem] sm:min-h-[16rem] sm:aspect-[2/1] lg:aspect-auto lg:min-h-[min(28rem,68vh)]"
                    >
                        @if (service_image_url($service->image_path))
                            <img
                                src="{{ service_image_url($service->image_path) }}"
                                alt="{{ $service->name }}"
                                class="absolute inset-0 h-full w-full object-cover"
                                loading="eager"
                                fetchpriority="high"
                            >
                        @else
                            <div class="absolute inset-0 flex items-center justify-center p-6 text-center text-sm text-text-muted">
                                {{ __('No image available') }}
                            </div>
                        @endif
                    </div>
                </figure>
            </div>

            {{-- Details --}}
            <div class="flex min-w-0 flex-col gap-6 lg:col-span-5 lg:gap-8">
                <header class="space-y-1">
                    <h1 class="text-3xl font-bold tracking-tight text-text sm:text-4xl xl:text-[2.5rem] xl:leading-tight">
                        {{ $service->name }}
                    </h1>
                </header>

                <div class="max-w-prose text-base leading-relaxed text-text-muted">
                    @if ($service->description)
                        <p>{{ $service->description }}</p>
                    @else
                        <p class="italic text-text-subtle">{{ __('No detailed description is available for this service yet.') }}</p>
                    @endif
                </div>

                <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-1">
                    <div class="rounded-xl border border-gray-200 bg-gray-50/90 px-4 py-4 shadow-sm">
                        <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Duration') }}</dt>
                        <dd class="mt-1.5 text-lg font-semibold text-gray-900">
                            {{ $service->duration }}
                            @if ($service->duration === 1)
                                {{ __('minute') }}
                            @else
                                {{ __('minutes') }}
                            @endif
                        </dd>
                    </div>
                </dl>

                <div class="service-price !mt-0">
                    <span class="service-price-label">{{ __('Price') }}</span>
                    <span class="service-price-amount">${{ number_format((float) $service->price, 2) }}</span>
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:flex-wrap sm:items-center">
                    <a
                        href="{{ route('frontend.book', ['service' => $service->id]) }}"
                        class="btn-primary order-1 min-h-12 w-full justify-center px-6 text-base sm:order-none sm:w-auto sm:min-w-[12rem]"
                    >
                        {{ __('Book now') }}
                    </a>
                    <a
                        href="{{ route('frontend.services') }}"
                        class="btn-secondary order-2 w-full justify-center sm:order-none sm:w-auto"
                    >
                        {{ __('All services') }}
                    </a>
                </div>

                @auth
                    @if (auth()->user()?->hasPermission('manage_services'))
                        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                            <span class="font-semibold">{{ __('Admin') }}:</span>
                            <a href="{{ route('services.edit', $service) }}" class="ml-1 font-medium text-indigo-700 underline hover:text-indigo-800">{{ __('Edit service') }}</a>
                            <span class="text-text-subtle"> · </span>
                            <a href="{{ route('services.index') }}" class="font-medium text-indigo-700 underline hover:text-indigo-800">{{ __('Manage catalog') }}</a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </section>
@endsection
