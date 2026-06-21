{{-- Simple pagination (prev/next only): matches custom pagination styling. --}}
@if ($paginator->hasPages())
    @php
        $btn = 'inline-flex min-h-11 min-w-[5.5rem] flex-1 items-center justify-center rounded-full border px-4 text-sm font-semibold transition-all duration-200 ease-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 active:scale-[0.98] sm:min-w-0 sm:flex-none sm:px-6';
        $idle = 'border-gray-200 bg-white text-gray-700 shadow-sm hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-800 hover:shadow-md';
        $disabled = 'cursor-not-allowed border-gray-100 bg-gray-50 text-gray-400 shadow-none hover:translate-y-0 hover:border-gray-100 hover:bg-gray-50 hover:text-gray-400 hover:shadow-none active:scale-100';
    @endphp

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex w-full justify-center">
        <div class="flex w-full max-w-md items-stretch justify-center gap-3 px-1 sm:w-auto sm:max-w-none">
            @if ($paginator->onFirstPage())
                <span class="{{ $btn }} {{ $disabled }}">
                    ‹ {{ __('Previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $btn }} {{ $idle }}">
                    ‹ {{ __('Previous') }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $btn }} {{ $idle }}">
                    {{ __('Next') }} ›
                </a>
            @else
                <span class="{{ $btn }} {{ $disabled }}">
                    {{ __('Next') }} ›
                </span>
            @endif
        </div>
    </nav>
@endif
