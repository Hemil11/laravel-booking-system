@extends('frontend.layouts.app')

@section('title', 'Book appointment')

@section('content')
    <section class="content-section">
        <h1 class="section-title">Book appointment</h1>
        <p class="mb-6 text-small text-text-muted">Choose a staff member, service, date, and available time slot.</p>

        @guest
            <div class="card">
                <p class="mb-4 text-small text-text-muted">Please sign in to submit an appointment request.</p>
                <a href="{{ route('login') }}" class="btn-primary inline-flex w-full justify-center rounded-xl py-3.5 text-base shadow-soft transition hover:-translate-y-0.5 hover:shadow-md">
                    Log in to continue
                </a>
            </div>
        @else
            <div class="card">
                <form method="post" action="{{ route('bookings.store') }}" id="public-booking-form">
                    @csrf

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label for="staff_id" class="block text-sm font-semibold text-text">Staff member</label>
                            <div class="relative">
                                <select
                                    id="staff_id"
                                    name="staff_id"
                                    required
                                    class="input appearance-none pr-10 transition @error('staff_id') border-danger focus:border-danger focus:ring-red-200 @enderror"
                                >
                                    <option value="">Select staff</option>
                                    @foreach ($staffMembers as $staff)
                                        <option value="{{ $staff->id }}" @selected(old('staff_id') == $staff->id)>{{ $staff->full_name }}</option>
                                    @endforeach
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1 text-text-subtle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @error('staff_id')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-2">
                            <label for="service_id" class="block text-sm font-semibold text-text">Service</label>
                            <div class="relative">
                                <select
                                    id="service_id"
                                    name="service_id"
                                    required
                                    class="input appearance-none pr-10 transition @error('service_id') border-danger focus:border-danger focus:ring-red-200 @enderror"
                                >
                                    <option value="">Select service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->name }} ({{ $service->duration }} min)</option>
                                    @endforeach
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1 text-text-subtle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @error('service_id')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-semibold text-text">Date</label>
                            <input
                                id="date"
                                name="date"
                                type="date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('date') }}"
                                required
                                    class="input transition @error('date') border-danger focus:border-danger focus:ring-red-200 @enderror"
                            >
                            @error('date')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-2">
                            <label for="time" class="block text-sm font-semibold text-text">Time slot</label>
                            <div class="relative">
                                <select
                                    id="time"
                                    name="time"
                                    required
                                    disabled
                                    class="input appearance-none pr-10 transition disabled:cursor-not-allowed disabled:opacity-60 @error('time') border-danger focus:border-danger focus:ring-red-200 @enderror"
                                >
                                    <option value="">Select staff, service and date first</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1 text-text-subtle" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div id="slots-hint" class="text-sm text-text-muted"></div>

                            <div id="selected-time-badge" class="hidden rounded-xl border border-brand-200 bg-brand-50 px-4 py-2 text-sm text-brand-700">
                                Selected time: <span id="selected-time-value" class="font-semibold"></span>
                            </div>

                            @error('time')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-semibold text-text">Notes (optional)</label>
                            <textarea
                                id="notes"
                                name="notes"
                                class="input min-h-28 resize-y py-3 transition @error('notes') border-danger focus:border-danger focus:ring-red-200 @enderror"
                            >{{ old('notes') }}</textarea>
                            @error('notes')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                        </div>

                        <button
                            type="submit"
                            id="book-submit"
                            class="btn-primary w-full rounded-xl px-4 py-3.5 text-base shadow-soft transition-all hover:-translate-y-0.5 hover:shadow-md disabled:opacity-60 disabled:cursor-not-allowed"
                            disabled
                        >
                            Submit booking
                        </button>
                    </div>
                </form>
            </div>
        @endguest
    </section>
@endsection

@auth
    @push('scripts')
    <script>
        (function () {
            const staff = document.getElementById('staff_id');
            const service = document.getElementById('service_id');
            const date = document.getElementById('date');
            const time = document.getElementById('time');
            const hint = document.getElementById('slots-hint');
            const submitBtn = document.getElementById('book-submit');
            const selectedBadge = document.getElementById('selected-time-badge');
            const selectedValue = document.getElementById('selected-time-value');
            const url = @json(route('bookings.available-slots'));

            async function fetchSlots() {
                time.innerHTML = '<option value="">Loading...</option>';
                time.disabled = true;
                submitBtn.disabled = true;
                hint.textContent = '';
                selectedBadge.classList.add('hidden');
                selectedValue.textContent = '';
                time.classList.remove('ring-2', 'ring-brand-200', 'border-brand-300');

                if (!staff.value || !service.value || !date.value) {
                    time.innerHTML = '<option value="">Select staff, service and date first</option>';
                    hint.textContent = '';
                    return;
                }

                const params = new URLSearchParams({
                    staff_id: staff.value,
                    service_id: service.value,
                    date: date.value
                });

                try {
                    const response = await fetch(url + '?' + params.toString(), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    });
                    const data = await response.json();
                    if (!response.ok) {
                        time.innerHTML = '<option value="">Unable to fetch slots</option>';
                        hint.textContent = data.message || 'Please try another date.';
                        return;
                    }

                    const slots = data.slots || [];
                    if (slots.length === 0) {
                        time.innerHTML = '<option value="">No slots available</option>';
                        hint.textContent = 'Try another date, staff member, or service.';
                        return;
                    }

                    time.innerHTML = '<option value="">Select time</option>';
                    slots.forEach(function (slot) {
                        const option = document.createElement('option');
                        option.value = slot.start.substring(0, 5);
                        option.textContent = slot.label;
                        time.appendChild(option);
                    });
                    time.disabled = false;
                    hint.textContent = 'Choose a time slot to continue.';
                } catch (error) {
                    time.innerHTML = '<option value="">Network error</option>';
                    hint.textContent = 'Please check your connection.';
                }
            }

            [staff, service, date].forEach(function (field) {
                field.addEventListener('change', fetchSlots);
            });

            time.addEventListener('change', function () {
                submitBtn.disabled = !time.value;

                if (!time.value) {
                    selectedBadge.classList.add('hidden');
                    selectedValue.textContent = '';
                    time.classList.remove('ring-2', 'ring-brand-200', 'border-brand-300');
                    return;
                }

                const selectedText = time.options[time.selectedIndex]?.textContent || time.value;
                selectedValue.textContent = selectedText.trim();
                selectedBadge.classList.remove('hidden');

                // Highlight the selected slot visually.
                time.classList.add('ring-2', 'ring-brand-200', 'border-brand-300');
            });

            if (staff.value && service.value && date.value) {
                fetchSlots();
            }
        })();
    </script>
    @endpush
@endauth
