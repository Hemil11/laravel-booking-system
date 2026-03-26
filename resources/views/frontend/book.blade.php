@extends('frontend.layouts.app')

@section('title', 'Book appointment')

@section('content')
    <section class="section" style="padding-top:2rem;">
        <h1 class="section-title">Book appointment</h1>
        <p style="margin:0 0 1rem; color:var(--muted);">Choose a staff member, service, date, and available time slot.</p>

        @guest
            <div class="card">
                <p style="margin:0 0 0.8rem;">Please sign in to submit an appointment request.</p>
                <a href="{{ route('login') }}" class="btn btn-primary">Log in to continue</a>
            </div>
        @else
            <div class="card">
                <form method="post" action="{{ route('bookings.store') }}" id="public-booking-form">
                    @csrf

                    <div class="form-field">
                        <label for="staff_id">Staff member</label>
                        <select id="staff_id" name="staff_id" required>
                            <option value="">Select staff</option>
                            @foreach ($staffMembers as $staff)
                                <option value="{{ $staff->id }}" @selected(old('staff_id') == $staff->id)>{{ $staff->full_name }}</option>
                            @endforeach
                        </select>
                        @error('staff_id')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field">
                        <label for="service_id">Service</label>
                        <select id="service_id" name="service_id" required>
                            <option value="">Select service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->name }} ({{ $service->duration }} min)</option>
                            @endforeach
                        </select>
                        @error('service_id')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field">
                        <label for="date">Date</label>
                        <input id="date" name="date" type="date" min="{{ now()->toDateString() }}" value="{{ old('date') }}" required>
                        @error('date')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field">
                        <label for="time">Time slot</label>
                        <select id="time" name="time" required disabled>
                            <option value="">Select staff, service and date first</option>
                        </select>
                        <div id="slots-hint" style="margin-top:0.35rem; color:var(--muted); font-size:0.85rem;"></div>
                        @error('time')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-field">
                        <label for="notes">Notes (optional)</label>
                        <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                        @error('notes')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" id="book-submit" class="btn btn-primary" disabled>Submit booking</button>
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
            const url = @json(route('bookings.available-slots'));

            async function fetchSlots() {
                time.innerHTML = '<option value="">Loading...</option>';
                time.disabled = true;
                submitBtn.disabled = true;
                hint.textContent = '';

                if (!staff.value || !service.value || !date.value) {
                    time.innerHTML = '<option value="">Select staff, service and date first</option>';
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
            });

            if (staff.value && service.value && date.value) {
                fetchSlots();
            }
        })();
    </script>
    @endpush
@endauth
