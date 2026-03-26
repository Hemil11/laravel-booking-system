@extends('layouts.admin')

@section('title', 'New booking')

@section('content')
    <div class="mb-6">
        <h1 class="text-h1 text-text">Book appointment</h1>
        <p class="mt-1 text-small text-text-muted">Select staff, service, date, and an available time slot.</p>
    </div>

    <x-card>
        <form method="post" action="{{ route('bookings.store') }}" id="booking-form" class="space-y-6">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="staff_id" class="block text-sm font-medium text-text">Staff</label>
                    <select id="staff_id" name="staff_id" class="input" required>
                        <option value="">Select staff</option>
                        @foreach ($staffMembers as $s)
                            <option value="{{ $s->id }}" @selected(old('staff_id') == $s->id)>{{ $s->full_name }}</option>
                        @endforeach
                    </select>
                    @error('staff_id')<p class="text-xs font-medium text-danger">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="service_id" class="block text-sm font-medium text-text">Service</label>
                    <select id="service_id" name="service_id" class="input" required>
                        <option value="">Select service</option>
                        @foreach ($services as $svc)
                            <option value="{{ $svc->id }}" @selected(old('service_id') == $svc->id)>
                                {{ $svc->name }} ({{ $svc->duration }} min)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="text-xs font-medium text-danger">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <x-form.input name="date" label="Date" type="date" :value="old('date')" :min="now()->toDateString()" required />

                <div class="space-y-1.5">
                    <p class="block text-sm font-medium text-text">Time slot</p>
                    <input type="hidden" id="time" name="time" value="{{ old('time') ? substr(old('time'), 0, 5) : '' }}" required>
                    <div id="slot-grid" class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
                        <p class="col-span-full rounded-xl border border-dashed border-border bg-background-muted px-3 py-4 text-center text-sm text-text-subtle">
                            Choose staff, service and date to view slots.
                        </p>
                    </div>
                    <p id="slots-hint" class="text-xs text-text-subtle"></p>
                    @error('time')<p class="text-xs font-medium text-danger">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="notes" class="block text-sm font-medium text-text">Notes (optional)</label>
                <textarea id="notes" name="notes" class="input min-h-24">{{ old('notes') }}</textarea>
                @error('notes')<p class="text-xs font-medium text-danger">{{ $message }}</p>@enderror
            </div>

            @error('booking')
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $message }}</div>
            @enderror

            <div class="flex flex-wrap gap-2">
                <x-button type="submit" id="submit-btn" disabled>Book appointment</x-button>
                <x-button variant="outline" href="{{ route('bookings.index') }}">Cancel</x-button>
            </div>
        </form>
    </x-card>

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
                el.className = 'col-span-full rounded-xl border border-dashed border-border bg-background-muted px-3 py-4 text-center text-sm text-text-subtle';
                el.textContent = message;
                slotGrid.appendChild(el);
            }

            function updateSubmitState() {
                submitBtn.disabled = !time.value;
            }

            function selectSlot(value, button) {
                time.value = value;
                slotGrid.querySelectorAll('button[data-slot]').forEach(function (el) {
                    el.className = 'rounded-xl border border-border bg-background-elevated px-3 py-2 text-sm font-medium text-text transition-all duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700';
                });
                button.className = 'rounded-xl border border-brand-500 bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-soft transition-all duration-200';
                updateSubmitState();
            }

            async function loadSlots() {
                renderPlaceholder('Loading available slots...');
                time.value = '';
                updateSubmitState();
                hint.textContent = '';

                if (!staff.value || !service.value || !date.value) {
                    renderPlaceholder('Choose staff, service and date to view slots.');
                    return;
                }

                const params = new URLSearchParams({ staff_id: staff.value, service_id: service.value, date: date.value });
                try {
                    const res = await fetch(url + '?' + params.toString(), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        renderPlaceholder('Unable to load slots right now.');
                        hint.textContent = data.message || 'Could not load slots.';
                        return;
                    }
                    const slots = data.slots || [];
                    if (slots.length === 0) {
                        renderPlaceholder('No slots available for this selection.');
                        hint.textContent = 'Try another date or staff member.';
                        return;
                    }
                    slotGrid.innerHTML = '';
                    slots.forEach(function (s) {
                        const value = s.start.substring(0, 5);
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.dataset.slot = value;
                        btn.className = 'rounded-xl border border-border bg-background-elevated px-3 py-2 text-sm font-medium text-text transition-all duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700';
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
                    renderPlaceholder('Network error while loading slots.');
                    hint.textContent = 'Network error.';
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
