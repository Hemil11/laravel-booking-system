@props([
    'title' => 'Filters',
])

<form method="get" {{ $attributes }}>
    <div class="mb-6 rounded-2xl border border-border/90 bg-background-elevated p-4 shadow-soft sm:p-5">
        <h2 class="mb-4 text-xs font-semibold uppercase tracking-wide text-text-muted">{{ $title }}</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6">
            {{ $slot }}
        </div>
        @isset($actions)
            <div class="mt-5 flex flex-wrap items-center gap-2 border-t border-border/80 pt-4">
                {{ $actions }}
            </div>
        @endisset
    </div>
</form>
