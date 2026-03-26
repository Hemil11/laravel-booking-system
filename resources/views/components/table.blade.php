<div {{ $attributes->class('overflow-x-auto rounded-2xl border border-border bg-background-elevated shadow-soft') }}>
    <table class="min-w-full divide-y divide-border">
        @isset($head)
            <thead class="bg-background-muted/70 text-left text-xs font-semibold uppercase tracking-wide text-text-muted">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endisset

        <tbody class="divide-y divide-border text-sm text-text">
            {{ $slot }}
        </tbody>
    </table>
</div>
