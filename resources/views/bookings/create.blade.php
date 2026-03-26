@extends('layouts.app')

@section('title', 'New booking')

@section('content')
    <h1>New booking</h1>

    <div class="card">
        <form method="post" action="{{ route('bookings.store') }}" id="booking-form">
            @csrf
            <div class="field">
                <label for="staff_id">Staff</label>
                <select id="staff_id" name="staff_id" required>
                    <option value="">— Select —</option>
                    @foreach ($staffMembers as $s)
                        <option value="{{ $s->id }}" @selected(old('staff_id') == $s->id)>{{ $s->full_name }}</option>
                    @endforeach
                </select>
                @error('staff_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="service_id">Service</label>
                <select id="service_id" name="service_id" required>
                    <option value="">— Select —</option>
                    @foreach ($services as $svc)
                        <option value="{{ $svc->id }}" @selected(old('service_id') == $svc->id)>
                            {{ $svc->name }} ({{ $svc->duration }} min)
                        </option>
                    @endforeach
                </select>
                @error('service_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="date">Date</label>
                <input id="date" name="date" type="date" value="{{ old('date') }}" min="{{ now()->toDateString() }}" required>
                @error('date')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="time">Start time</label>
                <select id="time" name="time" required disabled>
                    <option value="">— Choose staff, service, and date first —</option>
                </select>
                <div id="slots-hint" style="font-size: 0.8125rem; color: var(--muted); margin-top: 0.35rem;"></div>
                @error('time')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="notes">Notes (optional)</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                @error('notes')<div class="error">{{ $message }}</div>@enderror
            </div>

            @error('booking')<div class="error" style="margin-bottom: 1rem;">{{ $message }}</div>@enderror

            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Book</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-ghost">Cancel</a>
        </form>
    </div>

    @push('scripts')
    <script>
        (function () {
            const staff = document.getElementById('staff_id');
            const service = document.getElementById('service_id');
            const date = document.getElementById('date');
            const time = document.getElementById('time');
            const hint = document.getElementById('slots-hint');
            const submitBtn = document.getElementById('submit-btn');
            const url = @json(route('bookings.available-slots'));

            async function loadSlots() {
                time.innerHTML = '<option value="">Loading…</option>';
                time.disabled = true;
                submitBtn.disabled = true;
                hint.textContent = '';

                if (!staff.value || !service.value || !date.value) {
                    time.innerHTML = '<option value="">— Choose staff, service, and date —</option>';
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
                        time.innerHTML = '<option value="">— Error —</option>';
                        hint.textContent = data.message || 'Could not load slots.';
                        return;
                    }
                    const slots = data.slots || [];
                    if (slots.length === 0) {
                        time.innerHTML = '<option value="">No slots available</option>';
                        hint.textContent = 'Try another date or staff member.';
                        return;
                    }
                    time.innerHTML = '<option value="">— Select time —</option>';
                    slots.forEach(function (s) {
                        const opt = document.createElement('option');
                        opt.value = s.start.substring(0, 5);
                        opt.textContent = s.label;
                        time.appendChild(opt);
                    });
                    time.disabled = false;
                    const oldTime = @json(old('time'));
                    if (oldTime) {
                        time.value = oldTime.length >= 5 ? oldTime.substring(0, 5) : oldTime;
                    }
                    submitBtn.disabled = !time.value;
                } catch (e) {
                    time.innerHTML = '<option value="">— Error —</option>';
                    hint.textContent = 'Network error.';
                }
            }

            time.addEventListener('change', function () {
                submitBtn.disabled = !time.value;
            });

            [staff, service, date].forEach(function (el) {
                el.addEventListener('change', loadSlots);
            });

            if (staff.value && service.value && date.value) {
                loadSlots();
            }
        })();
    </script>
    @endpush
@endsection
