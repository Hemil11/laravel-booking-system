{{-- Custom pagination: centered, pill buttons, indigo active state, hover/focus (design system). --}}
@if ($paginator->hasPages())
    @php
        $pill = 'inline-flex min-h-10 items-center justify-center rounded-full border text-sm font-semibold transition-all duration-200 ease-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 active:scale-[0.97]';
        $navWide = $pill . ' min-w-[5.5rem] px-4';
        $pageBtn = $pill . ' min-w-10 px-3';
        $idle = 'border-gray-200 bg-white text-gray-700 shadow-sm hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-800 hover:shadow-md';
        $disabled = 'cursor-not-allowed border-gray-100 bg-gray-50 text-gray-400 shadow-none hover:translate-y-0 hover:border-gray-100 hover:bg-gray-50 hover:text-gray-400 hover:shadow-none active:scale-100';
        $current = 'inline-flex min-h-10 min-w-10 cursor-default items-center justify-center rounded-full border-2 border-indigo-600 bg-indigo-600 px-3 text-sm font-bold text-white shadow-md shadow-indigo-900/25 ring-2 ring-indigo-500/30';
        $mobileBtn = 'flex min-h-11 flex-1 items-center justify-center rounded-full border px-4 text-sm font-semibold transition-all duration-200 ease-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 active:scale-[0.98] sm:max-w-[11rem]';
    @endphp

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex w-full flex-col items-center justify-center">
        {{-- Desktop & tablet --}}
        <div class="hidden w-full max-w-full flex-col items-center sm:flex">
            <p class="mb-4 text-center text-sm text-gray-500">
                @if ($paginator->firstItem())
                    <span class="font-semibold text-gray-800">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold text-gray-800">{{ $paginator->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="font-semibold text-gray-800">{{ $paginator->total() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
            </p>

            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5">
                @if ($paginator->onFirstPage())
                    <span class="{{ $navWide }} {{ $disabled }}">
                        ‹ {{ __('Previous') }}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $navWide }} {{ $idle }}">
                        ‹ {{ __('Previous') }}
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex min-h-10 items-center justify-center rounded-full px-2 text-sm font-medium text-gray-400" aria-hidden="true">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="{{ $current }}">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="{{ $pageBtn }} {{ $idle }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $navWide }} {{ $idle }}">
                        {{ __('Next') }} ›
                    </a>
                @else
                    <span class="{{ $navWide }} {{ $disabled }}">
                        {{ __('Next') }} ›
                    </span>
                @endif
            </div>
        </div>

        {{-- Mobile --}}
        <div class="flex w-full flex-col items-center justify-center gap-4 sm:hidden">
            <p class="text-center text-xs font-medium text-gray-500">
                {{ __('Page') }}
                <span class="font-bold text-indigo-700">{{ $paginator->currentPage() }}</span>
                {{ __('of') }}
                <span class="font-semibold text-gray-700">{{ $paginator->lastPage() }}</span>
            </p>
            <div class="flex w-full max-w-md items-stretch justify-center gap-3 px-1">
                @if ($paginator->onFirstPage())
                    <span class="{{ $mobileBtn }} {{ $disabled }}">
                        ‹ {{ __('Previous') }}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $mobileBtn }} {{ $idle }}">
                        ‹ {{ __('Previous') }}
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $mobileBtn }} {{ $idle }}">
                        {{ __('Next') }} ›
                    </a>
                @else
                    <span class="{{ $mobileBtn }} {{ $disabled }}">
                        {{ __('Next') }} ›
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
