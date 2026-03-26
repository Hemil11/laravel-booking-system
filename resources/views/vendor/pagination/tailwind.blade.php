@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-text-muted">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-text">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-semibold text-text">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-semibold text-text">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center rounded-xl border border-border bg-slate-100 px-4 py-2 text-sm font-medium text-text-subtle opacity-70 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-xl border border-border bg-white px-4 py-2 text-sm font-medium text-text shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow">
                            Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center rounded-xl border border-transparent px-2 py-2 text-sm text-text-subtle">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="inline-flex min-w-10 items-center justify-center rounded-xl border border-brand-600 bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex min-w-10 items-center justify-center rounded-xl border border-border bg-white px-3 py-2 text-sm font-medium text-text shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700 hover:shadow">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-xl border border-border bg-white px-4 py-2 text-sm font-medium text-text shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow">
                            Next
                        </a>
                    @else
                        <span class="inline-flex items-center rounded-xl border border-border bg-slate-100 px-4 py-2 text-sm font-medium text-text-subtle opacity-70 cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </span>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-xl border border-border bg-slate-100 px-4 py-2 text-sm font-medium text-text-subtle opacity-70 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-xl border border-border bg-white px-4 py-2 text-sm font-medium text-text shadow-sm transition hover:bg-slate-50">
                    Previous
                </a>
            @endif

            <span class="text-sm font-medium text-text">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-xl border border-border bg-white px-4 py-2 text-sm font-medium text-text shadow-sm transition hover:bg-slate-50">
                    Next
                </a>
            @else
                <span class="inline-flex items-center rounded-xl border border-border bg-slate-100 px-4 py-2 text-sm font-medium text-text-subtle opacity-70 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif
