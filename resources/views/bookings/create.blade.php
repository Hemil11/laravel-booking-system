@extends('layouts.admin')

@section('title', __('New booking'))

@section('content')
    <x-admin.form-page
        :title="__('Book appointment')"
        :description="__('Choose staff, service, date, and an available time. Slots update when your selections change.')"
        :back-href="route('bookings.index')"
        :back-label="__('All bookings')"
    >
        <x-card :header="__('Appointment')">
            <form method="post" action="{{ route('bookings.store') }}" id="booking-form" class="space-y-8">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <x-form.select
                        name="staff_id"
                        label="{{ __('Staff') }}"
                        :options="$staffOptions"
                        empty-option="{{ __('Select staff…') }}"
                        :value="old('staff_id')"
                        required
                    />
                    <x-form.select
                        name="service_id"
                        label="{{ __('Service') }}"
                        :options="$serviceOptions"
                        empty-option="{{ __('Select service…') }}"
                        :value="old('service_id')"
                        required
                    />
                </div>

                <div class="grid gap-6 md:grid-cols-2 md:items-start">
                    <x-form.input
                        name="date"
                        type="date"
                        label="{{ __('Date') }}"
                        :value="old('date')"
                        :min="now()->toDateString()"
                        required
                    />

                    <div class="space-y-2">
                        <p class="block text-sm font-semibold text-text">
                            {{ __('Time slot') }}
                            <span class="text-danger">*</span>
                        </p>
                        <input type="hidden" id="time" name="time" value="{{ old('time') ? substr(old('time'), 0, 5) : '' }}" required>
                        <div
                            id="slot-grid"
                            class="grid grid-cols-2 gap-2 sm:grid-cols-3"
                        >
                            <p class="col-span-full rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                {{ __('Choose staff, service, and date to load available times.') }}
                            </p>
                        </div>
                        <p id="slots-hint" class="text-xs text-slate-500"></p>
                        @error('time')
                            <p class="text-xs font-medium text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <x-form.textarea
                    name="notes"
                    label="{{ __('Notes') }}"
                    :value="old('notes')"
                    rows="4"
                    placeholder="{{ __('Special requests or context (optional)') }}"
                />

                @error('booking')
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <div class="flex flex-wrap gap-3 border-t border-border pt-6">
                    <x-button type="submit" id="submit-btn" disabled>{{ __('Create booking') }}</x-button>
                    <x-button variant="outline" href="{{ route('bookings.index') }}">{{ __('Cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </x-admin.form-page>

    @push('scripts')
        <script>
            (function () {
                const staff = document.getElementById('staff_id');
                const service = document.getElementById('service_id');
                const date = document.getElementById('date');
                const time = document.getElementById('time');
                const slotGrid = document.getElementById('slot-grid');
                const hint = document.getElementById('slots-hint');
                const submitBtn = document.getElementById('submit-btn');
                const url = @json(route('bookings.available-slots'));
                const oldTime = @json(old('time'));
                const normalizedOldTime = oldTime ? oldTime.substring(0, 5) : '';

                function renderPlaceholder(message) {
                    slotGrid.innerHTML = '';
                    const el = document.createElement('p');
                    el.className =
                        'col-span-full rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500';
                    el.textContent = message;
                    slotGrid.appendChild(el);
                }

                function updateSubmitState() {
                    submitBtn.disabled = !time.value;
                }

                function selectSlot(value, button) {
                    time.value = value;
                    slotGrid.querySelectorAll('button[data-slot]').forEach(function (el) {
                        el.className =
                            'inline-flex items-center justify-center rounded-xl border-2 border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-brand-400 hover:bg-brand-50 hover:text-brand-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
                    });
                    button.className =
                        'inline-flex items-center justify-center rounded-xl border border-brand-700/20 bg-gradient-to-r from-brand-600 to-brand-700 px-3 py-2.5 text-sm font-semibold text-white shadow-md shadow-brand-600/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
                    updateSubmitState();
                }

                async function loadSlots() {
                    renderPlaceholder(@json(__('Loading available slots…')));
                    time.value = '';
                    updateSubmitState();
                    hint.textContent = '';

                    if (!staff.value || !service.value || !date.value) {
                        renderPlaceholder(@json(__('Choose staff, service, and date to load available times.')));
                        return;
                    }

                    const params = new URLSearchParams({ staff_id: staff.value, service_id: service.value, date: date.value });
                    try {
                        const res = await fetch(url + '?' + params.toString(), {
                            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            credentials: 'same-origin',
                        });
                        const data = await res.json();
                        if (!res.ok) {
                            renderPlaceholder(@json(__('Unable to load slots right now.')));
                            hint.textContent = data.message || @json(__('Could not load slots.'));
                            return;
                        }
                        const slots = data.slots || [];
                        if (slots.length === 0) {
                            renderPlaceholder(@json(__('No slots available for this selection.')));
                            hint.textContent = @json(__('Try another date or staff member.'));
                            return;
                        }
                        slotGrid.innerHTML = '';
                        slots.forEach(function (s) {
                            const value = s.start.substring(0, 5);
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.dataset.slot = value;
                            btn.className =
                                'inline-flex items-center justify-center rounded-xl border-2 border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-brand-400 hover:bg-brand-50 hover:text-brand-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2';
                            btn.textContent = s.label;
                            btn.addEventListener('click', function () {
                                selectSlot(value, btn);
                            });
                            slotGrid.appendChild(btn);
                        });
                        if (normalizedOldTime) {
                            const oldBtn = slotGrid.querySelector('button[data-slot="' + normalizedOldTime + '"]');
                            if (oldBtn) {
                                selectSlot(normalizedOldTime, oldBtn);
                            }
                        }
                    } catch (e) {
                        renderPlaceholder(@json(__('Network error while loading slots.')));
                        hint.textContent = @json(__('Check your connection and try again.'));
                    }
                }

                [staff, service, date].forEach(function (el) {
                    el.addEventListener('change', loadSlots);
                });

                if (staff.value && service.value && date.value) {
                    loadSlots();
                } else {
                    updateSubmitState();
                }
            })();
        </script>
    @endpush
@endsection
