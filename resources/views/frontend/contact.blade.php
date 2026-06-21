@extends('layouts.guest')

@section('title', __('Contact Support - ' . config('app.name')))

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
</style>
@endpush

@section('full_bleed')
<div class="bg-[#030508] text-white overflow-hidden relative min-h-screen" id="saas-contact-container">
    
    <!-- Cinematic Gradient Mesh & Light Ray Backgrounds -->
    <div class="mesh-background"></div>
    <div class="light-rays"></div>
    
    <!-- Canvas for Floating Particles -->
    <canvas id="particles-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40"></canvas>

    <!-- Header Section -->
    <section class="relative pt-24 pb-12 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-20 page-container z-10">
        <div class="space-y-4 max-w-3xl">
            <span class="inline-flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-300 backdrop-blur-xl shadow-inner shadow-white/5 select-none">
                Get In Touch
            </span>
            <h1 class="font-display text-5xl font-extrabold tracking-tight sm:text-6xl xl:text-7xl leading-[1.04] text-white">
                Contact our support <br>
                <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-cyan-400 bg-clip-text text-transparent">operations team.</span>
            </h1>
            <p class="max-w-2xl text-lg text-slate-400 leading-relaxed font-sans font-medium">
                Have questions about booking setups, custom session services, or platform configurations? Send us a direct support ticket.
            </p>
        </div>
    </section>

    <!-- Content Split Grid -->
    <section class="relative pb-24 sm:pb-32 page-container z-10">
        <div class="grid gap-8 lg:grid-cols-12 lg:items-start">
            
            <!-- Left: Contact Form -->
            <div class="lg:col-span-7 card p-6 sm:p-8 space-y-6">
                <h2 class="text-xl font-bold text-white font-display border-b border-white/5 pb-3">Send a Message</h2>
                
                @if ($errors->any())
                    <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-xs text-red-400 flex items-center gap-2 backdrop-blur-sm">
                        <svg class="h-4 w-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Please fix the highlighted fields and submit again.</span>
                    </div>
                @endif

                <form method="post" action="{{ route('frontend.contact.submit') }}" class="space-y-5 text-left">
                    @csrf

                    <x-form.input name="name" label="Name" type="text" placeholder="Enter your full name" maxlength="255" :value="old('name')" required />
                    
                    <x-form.input name="email" label="Email Address" type="email" placeholder="you@domain.com" maxlength="255" :value="old('email')" required />

                    <div class="space-y-1.5">
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-400">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            placeholder="Describe your inquiry in detail..."
                            maxlength="2000"
                            required
                            class="input min-h-32 resize-y @error('message') input-error @enderror"
                        >{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs font-medium text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center text-xs font-extrabold tracking-tight bg-white text-slate-950 hover:bg-slate-100 border-none py-3.5 rounded-xl shadow-md active:scale-95 transition-all">
                        Send Support Ticket
                    </button>
                </form>
            </div>

            <!-- Right: Details Card -->
            <div class="lg:col-span-5 space-y-6 text-left">
                <!-- Info Panel -->
                <div class="card p-6 sm:p-8 space-y-6">
                    <h2 class="text-xl font-bold text-white border-b border-white/5 pb-3">Office Information</h2>
                    
                    <div class="space-y-5 text-xs text-slate-400 font-sans">
                        <div class="flex items-start gap-3">
                            <span class="h-8 w-8 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-bold text-white">Corporate Headquarters</p>
                                <p class="mt-1 leading-relaxed">123 Booking Street, Suite 400<br>New York, NY 10001</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="h-8 w-8 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-bold text-white">Email Helpdesk</p>
                                <p class="mt-1">support@booking-saas.test</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="h-8 w-8 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 00.996.86h1.5a1 1 0 00.996-.86l.548-2.2A1 1 0 0116.28 3H19.5A2 2 0 0121 5v3a2 2 0 01-2 2h-1.5a1 1 0 00-.996.86l-.548 2.2a1 1 0 00-.996.86h-1.5a1 1 0 00-.996-.86l-.548-2.2a1 1 0 00-.996-.86H5a2 2 0 01-2-2V5z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-bold text-white">Telephone Hotlines</p>
                                <p class="mt-1">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="h-8 w-8 rounded-lg bg-brand-500/10 border border-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-bold text-white">Support Availability</p>
                                <p class="mt-1">Mon - Fri, 9:00 AM - 6:00 PM EST</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLA box -->
                <div class="card bg-[#0b0f19] border border-brand-500/10 p-6 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-brand-500/10 blur-2xl group-hover:bg-brand-500/15 transition-colors pointer-events-none"></div>
                    <h3 class="font-display font-bold text-base mb-2 text-white">Dedicated SLA Support</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-sans">Enterprise customers receive dedicated account managers and guaranteed 1-hour ticket response windows under formal SLA structures.</p>
                </div>
            </div>
            
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Particle canvas
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
            
            const container = document.getElementById('saas-contact-container');
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
    });
</script>
@endpush
