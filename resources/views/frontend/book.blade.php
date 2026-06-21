@extends('layouts.guest')

@section('title', __('Book Appointment - ' . config('app.name')))

@push('head')
<style>
    /* Gradient Mesh Background Motion */
    .mesh-background {
        position: absolute;
        inset: 0;
        background-color: #030508;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.16) 0%, transparent 45%),
            radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.16) 0%, transparent 45%),
            radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.14) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.08) 0%, transparent 40%);
        opacity: 0.9;
        z-index: 0;
        animation: mesh-drift 24s ease-in-out infinite alternate;
        will-change: transform;
    }

    @keyframes mesh-drift {
        0% { transform: scale(1) translate3d(0, 0, 0); }
        50% { transform: scale(1.08) translate3d(30px, -40px, 0); }
        100% { transform: scale(1) translate3d(-20px, 30px, 0); }
    }

    /* Light Ray Overlay */
    .light-rays {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.015) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }

    .light-rays::after {
        content: '';
        position: absolute;
        top: -20%;
        left: 20%;
        width: 150px;
        height: 140%;
        background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.04), transparent);
        transform: rotate(32deg);
        filter: blur(10px);
    }

    /* Step Transition Panes */
    .step-pane {
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        opacity: 1;
        transform: translateX(0);
    }
    
    .step-pane.hidden-slide-left {
        opacity: 0;
        transform: translateX(-24px);
        pointer-events: none;
        display: none;
    }

    .step-pane.hidden-slide-right {
        opacity: 0;
        transform: translateX(24px);
        pointer-events: none;
        display: none;
    }

    /* Selection Card Styling */
    .booking-select-card {
        @apply relative overflow-hidden rounded-2xl border border-white/5 bg-[#0d1324]/40 p-5 backdrop-blur-sm transition-all duration-300 cursor-pointer flex items-center justify-between text-white;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    .booking-select-card:hover {
        @apply border-brand-500/40 bg-slate-900/60 shadow-[0_12px_24px_rgba(0,0,0,0.4)];
    }

    .booking-select-card.active {
        @apply border-brand-500 ring-2 ring-brand-500/30 bg-slate-900/80;
    }

    /* Sticky Summary Widget */
    .sticky-summary {
        position: sticky;
        top: 7rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background-color: rgba(7, 11, 22, 0.95);
        padding: 2rem;
        backdrop-filter: blur(16px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }
</style>
@endpush

@section('full_bleed')
<div class="bg-[#030508] text-white overflow-hidden relative min-h-screen" id="saas-booking-container">
    
    <!-- Cinematic Gradient Mesh & Light Ray Backgrounds -->
    <div class="mesh-background"></div>
    <div class="light-rays"></div>
    
    <!-- Canvas for Floating Particles -->
    <canvas id="particles-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40"></canvas>

    <!-- Header Section -->
    <section class="relative pt-24 pb-12 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-20 page-container z-10">
        <div class="space-y-4 max-w-3xl">
            <span class="inline-flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-300 backdrop-blur-xl shadow-inner shadow-white/5 select-none">
                Scheduling System
            </span>
            <h1 class="font-display text-5xl font-extrabold tracking-tight sm:text-6xl xl:text-7xl leading-[1.04] text-white">
                Book your session <br>
                <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-cyan-400 bg-clip-text text-transparent">instantly.</span>
            </h1>
            <p class="max-w-2xl text-lg text-slate-400 leading-relaxed font-sans font-medium">
                Reserve custom slots with vetted professionals under enterprise-level booking conditions. Follow the wizard configuration below.
            </p>
        </div>
    </section>

    <!-- Main Wizard & Sticky Summary split grid -->
    <section class="relative pb-24 sm:pb-32 page-container z-10">
        @guest
            <!-- Authentication Gatekeeper UI -->
            <div class="card max-w-md mx-auto text-center space-y-6 py-10 relative overflow-hidden group">
                <div class="absolute -right-20 -top-20 h-44 w-44 rounded-full bg-brand-500/10 blur-2xl group-hover:bg-brand-500/20 transition-colors pointer-events-none"></div>
                <div class="mx-auto h-12 w-12 rounded-2xl bg-brand-500/20 border border-brand-500/30 flex items-center justify-center">
                    <svg class="h-6 w-6 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-bold tracking-tight text-white">{{ __('Authentication Required') }}</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ __('Sign in to access real-time scheduling databases and complete your appointment reservation.') }}</p>
                </div>
                <a href="{{ route('login') }}" class="btn-primary w-full justify-center bg-white text-slate-950 hover:bg-slate-100 border-none py-3.5 rounded-xl font-bold shadow-md">
                    {{ __('Log In to Continue') }}
                </a>
            </div>
        @else
            <!-- Authenticated Multi-Step Flow -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-start">
                
                <!-- Left: Form Stepper & Action Panes -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- Progress Stepper Tracker Bar -->
                    <div class="card p-6 space-y-5">
                        <div class="flex items-center justify-between text-xs font-bold uppercase tracking-widest text-slate-400">
                            <span id="wizard-step-label">Step 1 of 4: Select Service</span>
                            <span id="wizard-percentage" class="text-brand-400 font-extrabold">25% Complete</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-950 rounded-full overflow-hidden border border-white/5">
                            <div id="progress-bar" class="h-full bg-gradient-to-r from-brand-500 via-indigo-500 to-cyan-500 transition-all duration-300 w-1/4"></div>
                        </div>

                        <!-- Mini Step dots indicator -->
                        <div class="flex items-center justify-between pt-2 border-t border-white/5">
                            <div class="flex items-center gap-2 text-xs font-semibold" id="step-dot-1">
                                <span class="h-6 w-6 rounded-full bg-brand-500 text-white flex items-center justify-center text-[10px] font-bold">1</span>
                                <span class="text-white hidden sm:inline">Service</span>
                            </div>
                            <div class="h-px bg-white/5 flex-1 mx-2"></div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500" id="step-dot-2">
                                <span class="h-6 w-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-bold">2</span>
                                <span class="hidden sm:inline">Staff</span>
                            </div>
                            <div class="h-px bg-white/5 flex-1 mx-2"></div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500" id="step-dot-3">
                                <span class="h-6 w-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-bold">3</span>
                                <span class="hidden sm:inline">Schedule</span>
                            </div>
                            <div class="h-px bg-white/5 flex-1 mx-2"></div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500" id="step-dot-4">
                                <span class="h-6 w-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-bold">4</span>
                                <span class="hidden sm:inline">Confirm</span>
                            </div>
                        </div>
                    </div>

                    <!-- Wizard Form Container -->
                    <form method="post" action="{{ route('bookings.store') }}" id="wizard-booking-form">
                        @csrf

                        <!-- Hidden fields -->
                        <input type="hidden" id="service_id" name="service_id" value="{{ old('service_id', request('service')) }}" required>
                        <input type="hidden" id="staff_id" name="staff_id" value="{{ old('staff_id') }}" required>
                        <input type="hidden" id="date" name="date" value="{{ old('date') }}" required>
                        <input type="hidden" id="time" name="time" value="{{ old('time') }}" required>

                        <!-- PANE 1: SELECT SERVICE -->
                        <div id="pane-1" class="step-pane space-y-6">
                            <div class="space-y-1">
                                <h2 class="text-2xl font-bold tracking-tight text-white font-display">Choose a Service</h2>
                                <p class="text-sm text-slate-400">Select the workspace profile or consulting option you wish to schedule.</p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($services as $service)
                                    <div 
                                        class="booking-select-card group" 
                                        data-id="{{ $service->id }}" 
                                        data-name="{{ $service->name }}"
                                        data-duration="{{ $service->duration }} min"
                                        data-price="${{ number_format((float)$service->price, 2) }}"
                                        onclick="selectService(this)"
                                    >
                                        <div class="space-y-1.5 text-left">
                                            <h3 class="text-base font-bold text-white group-hover:text-brand-400 transition-colors leading-snug">{{ $service->name }}</h3>
                                            <span class="inline-block text-[9px] font-bold uppercase tracking-wider text-slate-400 bg-white/5 px-2.5 py-1 rounded-full border border-white/5">
                                                {{ $service->duration }} {{ __('min') }}
                                            </span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="block text-[8px] font-bold uppercase text-slate-500">Rate</span>
                                            <span class="text-sm font-extrabold text-brand-400">${{ number_format((float)$service->price, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- PANE 2: SELECT STAFF -->
                        <div id="pane-2" class="step-pane hidden-slide-right space-y-6">
                            <div class="space-y-1">
                                <h2 class="text-2xl font-bold tracking-tight text-white font-display">Select a Vetted Staff Member</h2>
                                <p class="text-sm text-slate-400">Select your preferred professional coordinator to host the session.</p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($staffMembers as $staff)
                                    <div 
                                        class="booking-select-card group" 
                                        data-id="{{ $staff->id }}" 
                                        data-name="{{ $staff->full_name }}"
                                        onclick="selectStaff(this)"
                                    >
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-brand-500/20 border border-brand-500/35 flex items-center justify-center text-xs font-bold text-brand-300 shrink-0">
                                                {{ substr($staff->full_name, 0, 2) }}
                                            </div>
                                            <div class="text-left">
                                                <h3 class="text-base font-bold text-white leading-none">{{ $staff->full_name }}</h3>
                                                <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase text-green-400 mt-1.5">
                                                    <span class="h-1 w-1 rounded-full bg-green-500 animate-ping"></span> Available
                                                </span>
                                            </div>
                                        </div>
                                        <span class="h-7 w-7 rounded-full bg-white/5 flex items-center justify-center text-slate-400 group-hover:bg-brand-500 group-hover:text-white transition-all text-xs font-bold shrink-0">
                                            →
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-4">
                                <button type="button" class="btn-secondary py-3 px-6 text-xs font-semibold" onclick="goToStep(1)">
                                    Back to Services
                                </button>
                            </div>
                        </div>

                        <!-- PANE 3: DATE & TIME SELECTOR -->
                        <div id="pane-3" class="step-pane hidden-slide-right space-y-6">
                            <div class="space-y-1">
                                <h2 class="text-2xl font-bold tracking-tight text-white font-display">Schedule Timeline</h2>
                                <p class="text-sm text-slate-400">Pick an open date on the scheduler and claim a confirmed time slot.</p>
                            </div>

                            <div class="grid gap-6 md:grid-cols-12 items-start">
                                <!-- Calendar box -->
                                <div class="md:col-span-5 space-y-2 text-left">
                                    <label for="date-input" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Pick Date</label>
                                    <input 
                                        type="date" 
                                        id="date-input" 
                                        min="{{ now()->toDateString() }}" 
                                        class="input"
                                        onchange="onDateChange(this.value)"
                                    >
                                </div>

                                <!-- Time slots -->
                                <div class="md:col-span-7 space-y-3 text-left">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500" id="time-grid-label">Available Slots</label>
                                    <div id="time-hint" class="text-xs font-semibold text-slate-500 italic">Select a date on the calendar first to pull open slots.</div>
                                    
                                    <div class="max-h-[220px] overflow-y-auto pr-1">
                                        <div id="time-slots" class="grid grid-cols-2 gap-2.5">
                                            <!-- Dyn -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-6 border-t border-white/5">
                                <button type="button" class="btn-secondary py-3 px-6 text-xs font-semibold" onclick="goToStep(2)">
                                    Back to Staff
                                </button>
                                <button type="button" id="next-to-step4" class="btn-primary py-3 px-6 text-xs font-bold text-slate-950 bg-white disabled:opacity-40 disabled:pointer-events-none" disabled onclick="goToStep(4)">
                                    Review Details
                                </button>
                            </div>
                        </div>

                        <!-- PANE 4: FINAL CONFIRMATION -->
                        <div id="pane-4" class="step-pane hidden-slide-right space-y-6">
                            <div class="space-y-1">
                                <h2 class="text-2xl font-bold tracking-tight text-white font-display">Submit Booking Inquiries</h2>
                                <p class="text-sm text-slate-400">Add operational details and click confirm to complete slot reservations.</p>
                            </div>

                            <div class="space-y-4">
                                <div class="space-y-2 text-left">
                                    <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Inquiry Notes (Optional)</label>
                                    <textarea
                                        id="notes"
                                        name="notes"
                                        placeholder="Outline specific setups or equipment requests for this booking session..."
                                        class="input min-h-[120px] resize-y text-xs"
                                    >{{ old('notes') }}</textarea>
                                </div>

                                <div class="rounded-2xl border border-brand-500/20 bg-brand-500/5 p-4 text-xs text-brand-300 flex items-start gap-2.5">
                                    <svg class="h-4 w-4 text-brand-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="leading-relaxed">By submitting, your slot is instantly reserved and synced to provider calendars. Real-time receipts will be dispatched immediately.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-6 border-t border-white/5">
                                <button type="button" class="btn-secondary py-3 px-6 text-xs font-semibold" onclick="goToStep(3)">
                                    Back to Calendar
                                </button>
                                <button type="submit" class="btn-primary py-3.5 px-8 text-xs font-extrabold text-white bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 border-none shadow-lg shadow-brand-500/25 active:scale-95 transition-all">
                                    Confirm Reservation
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Right: Sticky Booking Summary Panel -->
                <div class="lg:col-span-5">
                    <div class="sticky-summary space-y-6">
                        <!-- Panel Header -->
                        <div class="border-b border-white/5 pb-4">
                            <span id="summary-status-badge" class="inline-flex items-center gap-1.5 rounded-full bg-slate-500/10 border border-slate-500/20 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-400">
                                Session Summary
                            </span>
                            <h2 class="text-xl font-bold text-white mt-3 font-display">Reservation Receipt</h2>
                        </div>

                        <!-- Summary parameters -->
                        <div class="space-y-4 text-sm font-sans">
                            <!-- Service details block -->
                            <div class="space-y-1">
                                <span class="block text-[8px] font-bold uppercase tracking-wider text-slate-500">Service</span>
                                <div class="text-xs font-bold text-slate-300" id="summary-service">Select a service step...</div>
                                <div class="text-[9px] text-slate-500" id="summary-duration">-</div>
                            </div>

                            <!-- Professional coordinator block -->
                            <div class="space-y-1">
                                <span class="block text-[8px] font-bold uppercase tracking-wider text-slate-500">Professional Coordinator</span>
                                <div class="flex items-center gap-2.5 mt-1">
                                    <div class="h-6 w-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[9px] font-bold text-slate-300" id="summary-staff-avatar">
                                        ?
                                    </div>
                                    <div class="text-xs font-bold text-slate-300" id="summary-staff">Not selected</div>
                                </div>
                            </div>

                            <!-- Date time timeline block -->
                            <div class="space-y-1">
                                <span class="block text-[8px] font-bold uppercase tracking-wider text-slate-500">Scheduled Date & Time</span>
                                <div class="text-xs font-bold text-brand-400" id="summary-date">-</div>
                                <div class="text-[10px] font-extrabold text-brand-300" id="summary-time">-</div>
                            </div>
                        </div>

                        <!-- Live Cost breakdown widget -->
                        <div class="border-t border-white/5 pt-4 space-y-2">
                            <div class="flex justify-between text-xs text-slate-400 font-sans">
                                <span>Subtotal:</span>
                                <span id="summary-subtotal">$0.00</span>
                            </div>
                            <div class="flex justify-between text-xs text-slate-400 font-sans">
                                <span>Booking Fee:</span>
                                <span class="text-green-400">Free</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold text-white border-t border-white/5 pt-3 font-display">
                                <span>Total Amount:</span>
                                <span class="text-brand-400 font-extrabold text-base" id="summary-total">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endguest
    </section>

</div>
@endsection

@auth
    @push('scripts')
    <script>
        // Inputs mapping
        const fields = {
            service_id: document.getElementById('service_id'),
            staff_id: document.getElementById('staff_id'),
            date: document.getElementById('date'),
            time: document.getElementById('time')
        };

        // UI text elements
        const summaries = {
            service: document.getElementById('summary-service'),
            duration: document.getElementById('summary-duration'),
            staff: document.getElementById('summary-staff'),
            staffAvatar: document.getElementById('summary-staff-avatar'),
            date: document.getElementById('summary-date'),
            time: document.getElementById('summary-time'),
            subtotal: document.getElementById('summary-subtotal'),
            total: document.getElementById('summary-total'),
            statusBadge: document.getElementById('summary-status-badge')
        };

        let currentStep = 1;
        const slotsUrl = @json(route('bookings.available-slots'));

        // Handle Step Transitioning
        function goToStep(step) {
            const currentPane = document.getElementById(`pane-${currentStep}`);
            const nextPane = document.getElementById(`pane-${step}`);

            if (step > currentStep) {
                // Shift visual slide animations
                currentPane.className = 'step-pane hidden-slide-left';
                nextPane.className = 'step-pane';
            } else {
                currentPane.className = 'step-pane hidden-slide-right';
                nextPane.className = 'step-pane';
            }

            // Toggle visual indicators for dot stepper
            for (let i = 1; i <= 4; i++) {
                const dot = document.getElementById(`step-dot-${i}`);
                if (i <= step) {
                    dot.className = "flex items-center gap-2 text-xs font-semibold text-brand-400";
                    dot.querySelector('span').className = "h-6 w-6 rounded-full bg-brand-500 text-white flex items-center justify-center text-[10px] font-bold shadow-md shadow-brand-500/25";
                } else {
                    dot.className = "flex items-center gap-2 text-xs font-semibold text-slate-500";
                    dot.querySelector('span').className = "h-6 w-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-bold";
                }
            }

            currentStep = step;

            // Update Progress titles
            document.getElementById('wizard-step-label').textContent = `Step ${step} of 4: ` + getStepLabel(step);
            document.getElementById('wizard-percentage').textContent = `${step * 25}% Complete`;
            document.getElementById('progress-bar').style.width = `${step * 25}%`;

            // Adjust right badge status
            updateStatusBadge(step);
        }

        function getStepLabel(step) {
            switch(step) {
                case 1: return "Select Service";
                case 2: return "Select Coordinator";
                case 3: return "Schedule Timeline";
                case 4: return "Review Inquiry";
                default: return "";
            }
        }

        function updateStatusBadge(step) {
            if (step === 4) {
                summaries.statusBadge.textContent = "Ready to Confirm!";
                summaries.statusBadge.className = "inline-flex items-center gap-1.5 rounded-full bg-green-500/10 border border-green-500/20 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-green-400 animate-pulse";
            } else {
                summaries.statusBadge.textContent = `Configuring Step ${step}...`;
                summaries.statusBadge.className = "inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-brand-300";
            }
        }

        // Action selectors
        function selectService(card) {
            const id = card.getAttribute('data-id');
            const name = card.getAttribute('data-name');
            const duration = card.getAttribute('data-duration');
            const price = card.getAttribute('data-price');

            fields.service_id.value = id;
            summaries.service.textContent = name;
            summaries.duration.textContent = `${duration} session duration`;
            summaries.subtotal.textContent = price;
            summaries.total.textContent = price;

            // Highlight cards
            document.querySelectorAll('#pane-1 .booking-select-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');

            // Reset step 3 inputs if service changed
            fields.date.value = "";
            fields.time.value = "";
            document.getElementById('date-input').value = "";
            document.getElementById('time-slots').innerHTML = "";
            document.getElementById('next-to-step4').disabled = true;
            summaries.date.textContent = "-";
            summaries.time.textContent = "-";

            // Delayed transition
            setTimeout(() => goToStep(2), 250);
        }

        function selectStaff(card) {
            const id = card.getAttribute('data-id');
            const name = card.getAttribute('data-name');

            fields.staff_id.value = id;
            summaries.staff.textContent = name;
            summaries.staffAvatar.textContent = name.substring(0, 2).toUpperCase();

            // Highlight card
            document.querySelectorAll('#pane-2 .booking-select-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');

            // Reset step 3 inputs if staff changed
            fields.date.value = "";
            fields.time.value = "";
            document.getElementById('date-input').value = "";
            document.getElementById('time-slots').innerHTML = "";
            document.getElementById('next-to-step4').disabled = true;
            summaries.date.textContent = "-";
            summaries.time.textContent = "-";

            setTimeout(() => goToStep(3), 250);
        }

        function onDateChange(dateValue) {
            fields.date.value = dateValue;
            fields.time.value = "";
            document.getElementById('next-to-step4').disabled = true;
            summaries.time.textContent = "-";

            if (dateValue) {
                const parsedDate = new Date(dateValue);
                summaries.date.textContent = parsedDate.toLocaleDateString(undefined, { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                fetchSlots();
            } else {
                summaries.date.textContent = "-";
            }
        }

        async function fetchSlots() {
            const slotsContainer = document.getElementById('time-slots');
            const hint = document.getElementById('time-hint');

            slotsContainer.innerHTML = '';
            hint.textContent = 'Refreshing live schedules...';

            const params = new URLSearchParams({
                staff_id: fields.staff_id.value,
                service_id: fields.service_id.value,
                date: fields.date.value
            });

            try {
                const response = await fetch(slotsUrl + '?' + params.toString(), {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                });
                const data = await response.json();
                
                if (!response.ok) {
                    hint.textContent = data.message || 'Error pulling live calendar slots.';
                    return;
                }

                const slots = data.slots || [];
                if (slots.length === 0) {
                    hint.textContent = 'No available time slots. Select a different date.';
                    return;
                }

                hint.textContent = 'Select an hour slot:';

                slots.forEach(slot => {
                    const slotValue = slot.start.substring(0, 5);
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'py-3 px-4 rounded-xl border border-white/5 bg-black/40 text-xs font-semibold text-slate-300 hover:border-brand-500 hover:bg-brand-500/10 hover:text-white transition-all cursor-pointer active:scale-95 text-center';
                    btn.textContent = slot.label;

                    btn.addEventListener('click', () => {
                        // Toggle active state
                        document.querySelectorAll('#time-slots button').forEach(b => {
                            b.className = 'py-3 px-4 rounded-xl border border-white/5 bg-black/40 text-xs font-semibold text-slate-300 hover:border-brand-500 hover:bg-brand-500/10 hover:text-white transition-all cursor-pointer active:scale-95 text-center';
                        });
                        btn.className = 'py-3 px-4 rounded-xl border-brand-500 bg-brand-500 text-white text-xs font-extrabold shadow-md shadow-brand-500/25 active:scale-95 transition-all text-center';

                        fields.time.value = slotValue;
                        summaries.time.textContent = slot.label;
                        document.getElementById('next-to-step4').disabled = false;
                        
                        setTimeout(() => goToStep(4), 250);
                    });

                    slotsContainer.appendChild(btn);
                });

            } catch (error) {
                hint.textContent = 'Connection error pulling database schedules.';
            }
        }

        // Initialize state values if redirected back
        window.addEventListener('DOMContentLoaded', () => {
            if (fields.service_id.value) {
                const serviceCard = document.querySelector(`#pane-1 .booking-select-card[data-id="${fields.service_id.value}"]`);
                if (serviceCard) selectService(serviceCard);
            }
        });

        // Particle layout
        const canvas = document.getElementById('particles-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let particles = [];
            
            function resizeCanvas() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            class Particle {
                constructor() {
                    this.reset();
                }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 1.5 + 0.5;
                    this.speedX = Math.random() * 0.3 - 0.15;
                    this.speedY = Math.random() * 0.3 - 0.15;
                    this.life = Math.random() * 0.6 + 0.2;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) {
                        this.reset();
                    }
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(167, 139, 250, ${this.life})`;
                    ctx.fill();
                }
            }

            for (let i = 0; i < 40; i++) {
                particles.push(new Particle());
            }

            let animId;
            let isVisible = true;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    isVisible = entry.isIntersecting;
                    if (isVisible) {
                        animate();
                    } else {
                        cancelAnimationFrame(animId);
                    }
                });
            }, { threshold: 0.01 });
            
            const container = document.getElementById('saas-booking-container');
            if (container) {
                observer.observe(container);
            } else {
                observer.observe(canvas);
            }

            function animate() {
                if (!isVisible) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                animId = requestAnimationFrame(animate);
            }
        }
    </script>
    @endpush
@endauth
