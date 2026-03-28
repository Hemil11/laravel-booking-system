{{-- Shared default pagination (Paginator::defaultView). Indigo / brand theme, rounded controls, centered. --}}
@if ($paginator->hasPages())
    @php
        $linkNav = 'inline-flex min-h-10 items-center justify-center rounded-xl border px-3.5 py-2 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
        $linkBase = 'inline-flex min-h-10 min-w-10 items-center justify-center rounded-xl border px-3 py-2 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
        $linkIdle = 'border-slate-200 bg-white text-slate-700 shadow-sm hover:border-brand-400 hover:bg-brand-50 hover:text-brand-800';
        $linkDisabled = 'cursor-not-allowed border-slate-100 bg-slate-50 text-slate-400 shadow-none';
        $pageActive = 'inline-flex min-h-10 min-w-10 items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-brand-700 px-3 py-2 text-sm font-bold text-white shadow-md shadow-brand-600/25 ring-2 ring-brand-400/40';
        $mobileBtn = 'flex min-h-10 flex-1 items-center justify-center rounded-xl border px-3 py-2 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
    @endphp

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="mx-auto w-full max-w-full">
        {{-- Desktop & tablet --}}
        <div class="hidden w-full flex-col items-center justify-center sm:flex">
            <p class="mb-4 text-center text-sm text-slate-500">
                @if ($paginator->firstItem())
                    <span class="font-semibold text-slate-800">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold text-slate-800">{{ $paginator->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="font-semibold text-slate-800">{{ $paginator->total() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                @if ($paginator->onFirstPage())
                    <span class="{{ $linkNav }} {{ $linkDisabled }}">
                        ‹ {{ __('Previous') }}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $linkNav }} {{ $linkIdle }}">
                        ‹ {{ __('Previous') }}
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-1.5 py-2 text-sm font-medium text-slate-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="{{ $pageActive }}">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="{{ $linkBase }} {{ $linkIdle }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $linkNav }} {{ $linkIdle }}">
                        {{ __('Next') }} ›
                    </a>
                @else
                    <span class="{{ $linkNav }} {{ $linkDisabled }}">
                        {{ __('Next') }} ›
                    </span>
                @endif
            </div>
        </div>

        {{-- Mobile --}}
        <div class="flex w-full flex-col items-center justify-center gap-3 sm:hidden">
            <p class="text-center text-xs font-medium text-slate-500">
                {{ __('Page') }}
                <span class="font-bold text-brand-700">{{ $paginator->currentPage() }}</span>
                {{ __('of') }}
                <span class="font-semibold text-slate-700">{{ $paginator->lastPage() }}</span>
            </p>
            <div class="flex w-full max-w-md items-stretch justify-center gap-3">
                @if ($paginator->onFirstPage())
                    <span class="{{ $mobileBtn }} {{ $linkDisabled }}">
                        ‹ {{ __('Previous') }}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $mobileBtn }} {{ $linkIdle }}">
                        ‹ {{ __('Previous') }}
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $mobileBtn }} {{ $linkIdle }}">
                        {{ __('Next') }} ›
                    </a>
                @else
                    <span class="{{ $mobileBtn }} {{ $linkDisabled }}">
                        {{ __('Next') }} ›
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
