@extends('layouts.admin')

@section('title', __('Booking calendar'))

@section('content')
    @php
        $periodLabel = $viewMode === 'week'
            ? $weekStart->format('M j').' – '.$weekStart->copy()->addDays(6)->format('M j, Y')
            : $anchor->format('l, F j, Y');
    @endphp

    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:flex-wrap lg:items-end lg:justify-between">
        <div>
            <h1 class="text-h1 text-text">{{ __('Booking calendar') }}</h1>
            <p class="mt-2 text-small text-text-muted">
                {{ __('Day and week views with booked appointments. Select a staff member to open free slots for new bookings.') }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <x-button variant="outline" href="{{ route('bookings.index') }}">{{ __('List view') }}</x-button>
            <x-button href="{{ route('bookings.create') }}">{{ __('New booking') }}</x-button>
        </div>
    </div>

    <x-card class="mb-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:flex-wrap lg:items-end lg:justify-between">
            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ $navUrls['prev'] }}"
                    class="btn-secondary inline-flex items-center justify-center px-3 py-2 text-sm font-medium"
                >
                    {{ $viewMode === 'week' ? __('Previous week') : __('Previous day') }}
                </a>
                <a
                    href="{{ $navUrls['today'] }}"
                    class="btn-secondary inline-flex items-center justify-center px-3 py-2 text-sm font-medium"
                >
                    {{ __('Today') }}
                </a>
                <a
                    href="{{ $navUrls['next'] }}"
                    class="btn-secondary inline-flex items-center justify-center px-3 py-2 text-sm font-medium"
                >
                    {{ $viewMode === 'week' ? __('Next week') : __('Next day') }}
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ $navUrls['day'] }}"
                    @class([
                        'inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold transition',
                        'bg-indigo-600 text-white shadow-sm' => $viewMode === 'day',
                        'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50' => $viewMode !== 'day',
                    ])
                >
                    {{ __('Day') }}
                </a>
                <a
                    href="{{ $navUrls['week'] }}"
                    @class([
                        'inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold transition',
                        'bg-indigo-600 text-white shadow-sm' => $viewMode === 'week',
                        'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50' => $viewMode !== 'week',
                    ])
                >
                    {{ __('Week') }}
                </a>
            </div>

            <form method="get" action="{{ route('bookings.calendar') }}" class="flex min-w-[min(100%,16rem)] flex-col gap-2 sm:min-w-[14rem]">
                <input type="hidden" name="view" value="{{ $viewMode }}">
                <input type="hidden" name="date" value="{{ $anchor->toDateString() }}">
                <label for="calendar-staff" class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    {{ __('Staff filter') }}
                </label>
                <select
                    id="calendar-staff"
                    name="staff_id"
                    class="input w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm"
                    onchange="this.form.submit()"
                >
                    <option value="">{{ __('All staff') }}</option>
                    @foreach ($staffOptions as $id => $name)
                        <option value="{{ $id }}" @selected($staffId === (int) $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <p class="mt-6 text-center text-sm font-semibold text-gray-900">{{ $periodLabel }}</p>

        @if (! $staffId)
            <p class="mt-3 rounded-xl border border-dashed border-amber-200 bg-amber-50/80 px-4 py-3 text-sm text-amber-900">
                {{ __('Choose a staff member to turn empty working hours into clickable slots that open the booking form with the time prefilled.') }}
            </p>
        @endif
    </x-card>

    <div class="-mx-2 overflow-x-auto pb-2 sm:mx-0">
        <div class="inline-block min-w-full px-2 align-middle sm:px-0">
            <div class="flex gap-0 border border-gray-200 bg-white shadow-sm ring-1 ring-black/5 rounded-2xl overflow-hidden">
                <div
                    class="w-14 shrink-0 border-r border-gray-200 bg-gray-50 sm:w-16"
                    style="min-height: {{ (int) $calendarHeight + 48 }}px"
                >
                    <div class="h-12 border-b border-gray-200"></div>
                    <div class="relative" style="height: {{ (int) $calendarHeight }}px">
                        @foreach ($timeLabels as $row)
                            <div
                                class="absolute left-0 right-0 border-b border-gray-100 pr-1 text-right text-[10px] font-medium text-gray-500 sm:text-xs"
                                style="top: {{ number_format($row['topPx'], 2, '.', '') }}px; height: {{ (int) ($slotStep / $totalMinutes * $calendarHeight) }}px"
                            >
                                {{ $row['label'] }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div @class([
                    'flex min-w-0 flex-1',
                    'flex-col' => $viewMode === 'day',
                    'flex-row' => $viewMode === 'week',
                ])>
                    @foreach ($dayMetas as $dayMeta)
                        <div
                            @class([
                                'min-w-0 flex-1 border-gray-200',
                                'border-b last:border-b-0' => $viewMode === 'day',
                                'min-w-[7.25rem] border-r last:border-r-0 sm:min-w-0' => $viewMode === 'week',
                            ])
                        >
                            <div
                                @class([
                                    'flex h-12 flex-col items-center justify-center border-b border-gray-200 px-1 text-center',
                                    'bg-indigo-50/80' => $dayMeta['isToday'],
                                ])
                            >
                                <span class="text-xs font-bold uppercase tracking-wide text-gray-500">{{ $dayMeta['label'] }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $dayMeta['subLabel'] }}</span>
                            </div>

                            <div class="relative bg-white" style="height: {{ (int) $calendarHeight }}px">
                                @foreach ($dayMeta['clickableSlots'] as $slot)
                                    <a
                                        href="{{ $slot['href'] }}"
                                        class="absolute left-1 right-1 z-10 rounded-lg border border-transparent transition hover:border-indigo-300 hover:bg-indigo-50/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-0 focus-visible:outline-indigo-500"
                                        style="top: {{ number_format($slot['topPx'], 2, '.', '') }}px; height: {{ number_format($slot['heightPx'], 2, '.', '') }}px"
                                        title="{{ __('Book this slot') }}"
                                    >
                                        <span class="sr-only">{{ __('Book slot starting') }}</span>
                                    </a>
                                @endforeach

                                @foreach ($dayMeta['blocks'] as $block)
                                    @php
                                        /** @var \App\Models\Booking $b */
                                        $b = $block['booking'];
                                        $status = strtolower((string) $b->status);
                                        $tone = match ($status) {
                                            'confirmed' => 'border-green-200 bg-green-50 text-green-900 ring-green-100',
                                            'completed' => 'border-sky-200 bg-sky-50 text-sky-900 ring-sky-100',
                                            'pending' => 'border-amber-200 bg-amber-50 text-amber-900 ring-amber-100',
                                            default => 'border-gray-200 bg-gray-50 text-gray-900 ring-gray-100',
                                        };
                                    @endphp
                                    <a
                                        href="{{ route('bookings.show', $b) }}"
                                        class="absolute z-20 overflow-hidden rounded-lg border px-1.5 py-1 text-left text-[11px] font-medium leading-snug shadow-sm ring-1 ring-inset transition hover:brightness-[0.98] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-0 focus-visible:outline-indigo-500 sm:text-xs {{ $tone }}"
                                        style="top: {{ number_format($block['top'], 2, '.', '') }}px; height: {{ number_format($block['height'], 2, '.', '') }}px; left: {{ number_format($block['leftPct'], 2, '.', '') }}%; width: {{ number_format($block['widthPct'], 2, '.', '') }}%; min-height: 20px"
                                    >
                                        <span class="block truncate font-semibold">{{ $b->service?->name ?? __('Service') }}</span>
                                        @if (! $staffId && $b->staff)
                                            <span class="block truncate text-[10px] opacity-90 sm:text-xs">{{ $b->staff->full_name }}</span>
                                        @endif
                                        <span class="block truncate text-[10px] opacity-80 sm:text-xs">{{ $b->user?->name ?? '—' }}</span>
                                        <span class="mt-0.5 inline-flex items-center rounded-full bg-white/60 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wide ring-1 ring-inset ring-black/5">
                                            {{ __($b->status) }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
