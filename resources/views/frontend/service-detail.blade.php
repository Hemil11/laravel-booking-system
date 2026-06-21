@extends('layouts.guest')

@section('title', $service->name . ' - ' . config('app.name'))

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
<div class="bg-[#030508] text-white overflow-hidden relative min-h-screen" id="saas-service-detail-container">
    
    <!-- Cinematic Gradient Mesh & Light Ray Backgrounds -->
    <div class="mesh-background"></div>
    <div class="light-rays"></div>
    
    <!-- Canvas for Floating Particles -->
    <canvas id="particles-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40"></canvas>

    <!-- Header Section (Breadcrumbs & Title) -->
    <section class="relative pt-24 pb-8 sm:pt-32 sm:pb-12 lg:pt-40 lg:pb-16 page-container z-10">
        <div class="space-y-4 max-w-3xl">
            <!-- Breadcrumbs -->
            <nav class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-500 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('frontend.home') }}" class="hover:text-white transition-colors">Home</a>
                <svg class="h-3 w-3 stroke-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('frontend.services') }}" class="hover:text-white transition-colors">Services</a>
                <svg class="h-3 w-3 stroke-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-300 font-extrabold">{{ $service->name }}</span>
            </nav>

            <span class="inline-flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-300 backdrop-blur-xl shadow-inner shadow-white/5 select-none">
                Service Showcase
            </span>
            <h1 class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white leading-tight">
                {{ $service->name }}
            </h1>
        </div>
    </section>

    <!-- Main Detail Showcase Grid -->
    <section class="relative pb-24 sm:pb-32 page-container z-10">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-start lg:gap-14">
            
            <!-- Left Side: Image Showcase -->
            <div class="lg:col-span-7">
                <div class="relative overflow-hidden rounded-[2.5rem] border border-white/5 bg-[#0d1324]/50 shadow-2xl p-4 backdrop-blur-sm sticky top-28">
                    <div class="aspect-[16/10] w-full rounded-2xl overflow-hidden bg-slate-900 border border-white/5">
                        @if (service_image_url($service->image_path))
                            <img
                                src="{{ service_image_url($service->image_path) }}"
                                alt="{{ $service->name }}"
                                class="h-full w-full object-cover"
                                loading="eager"
                            >
                        @else
                            <div class="flex flex-col h-full w-full items-center justify-center p-8 text-slate-500 text-sm font-semibold bg-white/5">
                                <svg class="h-10 w-10 text-slate-600 mb-3 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>No showcase image set</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Details & Action parameters -->
            <div class="lg:col-span-5 space-y-6 text-left">
                <!-- Description -->
                <div class="card space-y-4">
                    <h2 class="text-lg font-bold text-white font-display">Service Description</h2>
                    <div class="text-sm text-slate-400 leading-relaxed font-sans">
                        @if ($service->description)
                            <p>{{ $service->description }}</p>
                        @else
                            <p class="italic text-slate-500 font-sans">No description has been outlined for this service.</p>
                        @endif
                    </div>
                </div>

                <!-- Duration & Rate Cards -->
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    <!-- Duration -->
                    <div class="card p-5 flex items-center justify-between">
                        <div>
                            <span class="block text-[8px] font-bold uppercase tracking-wider text-slate-500">Session Duration</span>
                            <span class="mt-1 block text-lg font-extrabold text-white font-display">
                                {{ $service->duration }} minutes
                            </span>
                        </div>
                        <span class="h-10 w-10 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>

                    <!-- Price Rate -->
                    <div class="card p-5 flex items-center justify-between border-brand-500/20 bg-brand-500/5">
                        <div>
                            <span class="block text-[8px] font-bold uppercase tracking-wider text-slate-500">Session Rate</span>
                            <span class="mt-1 block text-lg font-extrabold text-brand-400 font-display">
                                ${{ number_format((float) $service->price, 2) }}
                            </span>
                        </div>
                        <span class="h-10 w-10 rounded-xl bg-brand-500/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-col gap-3 pt-4 border-t border-white/5">
                    <a
                        href="{{ route('frontend.book', ['service' => $service->id]) }}"
                        class="btn-primary min-h-[3.25rem] w-full justify-center text-sm font-extrabold text-slate-950 bg-white hover:bg-slate-100 border-none shadow-md active:scale-95 transition-all"
                    >
                        Book Appointment Now
                    </a>
                    <a
                        href="{{ route('frontend.services') }}"
                        class="btn-secondary min-h-[3.25rem] w-full justify-center text-sm font-bold active:scale-95 transition-all"
                    >
                        View Other Services
                    </a>
                </div>

                <!-- Admin console link -->
                @auth
                    @if (auth()->user()?->hasPermission('manage_services'))
                        <div class="rounded-2xl border border-amber-500/25 bg-amber-500/5 p-4 text-xs flex items-center justify-between backdrop-blur-sm">
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-ping"></span>
                                <span class="font-bold uppercase tracking-wider text-amber-400">Administrator Console</span>
                            </div>
                            <div class="flex gap-3 font-semibold">
                                <a href="{{ route('services.edit', $service) }}" class="text-amber-400 hover:text-amber-300 underline">Edit</a>
                                <a href="{{ route('services.index') }}" class="text-amber-400 hover:text-amber-300 underline">Manage</a>
                            </div>
                        </div>
                    @endif
                @endauth
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
            
            const container = document.getElementById('saas-service-detail-container');
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
