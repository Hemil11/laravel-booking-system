@extends('layouts.guest')

@section('title', __('Services Catalog - ' . config('app.name')))

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

    /* Active Highlight Border */
    .bento-active {
        border-color: var(--color-brand-500) !important;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.3) !important;
        background-color: rgba(13, 19, 36, 0.8) !important;
    }

    /* Custom Glass Panel for Inspector */
    .inspector-panel {
        position: sticky;
        top: 7rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background-color: rgba(7, 11, 22, 0.9);
        padding: 2rem;
        backdrop-filter: blur(16px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }
</style>
@endpush

@section('full_bleed')
<div class="bg-[#030508] text-white overflow-hidden relative min-h-screen" id="saas-services-container">
    
    <!-- Cinematic Gradient Mesh & Light Ray Backgrounds -->
    <div class="mesh-background"></div>
    <div class="light-rays"></div>
    
    <!-- Canvas for Floating Particles -->
    <canvas id="particles-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40"></canvas>

    <!-- Header Section -->
    <section class="relative pt-24 pb-12 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-20 page-container z-10">
        <div class="space-y-4 max-w-3xl">
            <span class="inline-flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-300 backdrop-blur-xl shadow-inner shadow-white/5 select-none">
                Services Directory
            </span>
            <h1 class="font-display text-5xl font-extrabold tracking-tight sm:text-6xl xl:text-7xl leading-[1.04] text-white">
                Vetted workspace <br>
                <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-cyan-400 bg-clip-text text-transparent">session catalog.</span>
            </h1>
            <p class="max-w-2xl text-lg text-slate-400 leading-relaxed font-sans font-medium">
                Browse our curated selection of private offices, creative studio spaces, and private consultant rooms. Compare details and reserve your slot instantly.
            </p>
        </div>
    </section>

    <!-- Featured Service Highlight Section (Only if services exist) -->
    @if($services->count() > 0)
        @php
            $featuredService = $services->first();
        @endphp
        <section class="relative pb-16 page-container z-10">
            <div class="card bg-gradient-to-tr from-slate-900 via-[#0a0e1a] to-brand-950/40 border border-brand-500/20 p-8 sm:p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-brand-500/10 blur-[90px] pointer-events-none"></div>
                <div class="grid gap-8 md:grid-cols-12 items-center">
                    
                    <!-- Left: Text Info -->
                    <div class="md:col-span-7 space-y-5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-brand-300">
                            ★ Featured Service of the Month
                        </span>
                        <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-white tracking-tight leading-tight">
                            {{ $featuredService->name }}
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xl font-sans">
                            {{ $featuredService->description ?: __('Experience our premium scheduling workspace service. Hand-picked and recommended for maximum workflow output.') }}
                        </p>
                        
                        <div class="flex items-center gap-6 text-sm border-y border-white/5 py-4 my-2">
                            <div>
                                <span class="block text-[9px] font-bold uppercase text-slate-500">Duration</span>
                                <span class="text-white font-bold">{{ $featuredService->duration }} minutes</span>
                            </div>
                            <div class="h-8 border-l border-white/5"></div>
                            <div>
                                <span class="block text-[9px] font-bold uppercase text-slate-500">Rate</span>
                                <span class="text-brand-400 font-extrabold text-lg">${{ number_format((float) $featuredService->price, 2) }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="{{ route('frontend.book', ['service' => $featuredService->id]) }}" class="btn-primary bg-white text-slate-950 hover:bg-slate-100 border-none px-6 py-3 rounded-xl font-extrabold shadow-md active:scale-95 transition-all">
                                Book This Slot
                            </a>
                            <a href="{{ route('frontend.services.show', ['id' => $featuredService->id]) }}" class="btn-secondary bg-white/5 border-white/10 hover:border-white/20 text-white px-6 py-3 rounded-xl font-bold active:scale-95 transition-all">
                                View Details
                            </a>
                        </div>
                    </div>

                    <!-- Right: Large Image -->
                    <div class="md:col-span-5 relative">
                        <div class="aspect-[16/10] w-full rounded-2xl overflow-hidden bg-slate-900 border border-white/5 relative shadow-2xl">
                            @if (service_image_url($featuredService->image_path))
                                <img src="{{ service_image_url($featuredService->image_path) }}" alt="{{ $featuredService->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-xs text-slate-600 font-semibold bg-white/5">
                                    No Image Available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Main Filtering and Catalog Section -->
    <section class="relative pb-24 sm:pb-32 page-container z-10">
        <!-- Control Bar: Search + Category Chips -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10 border-b border-white/5 pb-8">
            <!-- Search bar -->
            <div class="relative max-w-md w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Search services by title or description..." 
                    class="input pl-10 pr-4 py-3 text-xs w-full"
                >
            </div>

            <!-- Category Pills/Chips -->
            <div class="flex flex-wrap gap-2" id="filter-bar">
                <button class="px-4 py-2 rounded-full text-xs font-semibold border border-brand-500 bg-brand-500 text-white shadow-md shadow-brand-500/20 transition-all hover:opacity-90 cursor-pointer" data-filter="all">
                    All Services
                </button>
                <button class="px-4 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white cursor-pointer" data-filter="short">
                    Short (< 45 min)
                </button>
                <button class="px-4 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white cursor-pointer" data-filter="long">
                    Long (≥ 45 min)
                </button>
                <button class="px-4 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white cursor-pointer" data-filter="premium">
                    Premium Rates (+$80)
                </button>
            </div>
        </div>

        <!-- Master Split Layout: Catalog List + Spotlight Inspector -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-start">
            
            <!-- Left: Catalog of service cards -->
            <div class="lg:col-span-7 space-y-6" id="services-grid">
                @forelse($services as $index => $service)
                    @php
                        $isLong = $service->duration >= 45 ? 'long' : 'short';
                        $isPremium = $service->price >= 80 ? 'premium' : 'budget';
                    @endphp
                    <article 
                        class="card card-hover group flex flex-col justify-between relative overflow-hidden transition-all duration-300 cursor-pointer service-item"
                        data-id="{{ $service->id }}"
                        data-name="{{ $service->name }}"
                        data-duration="{{ $service->duration }} minutes"
                        data-price="${{ number_format((float) $service->price, 2) }}"
                        data-desc="{{ $service->description ?: __('A premium service session configured to optimize operations.') }}"
                        data-img="{{ service_image_url($service->image_path) ?: '' }}"
                        data-book-url="{{ route('frontend.book', ['service' => $service->id]) }}"
                        data-detail-url="{{ route('frontend.services.show', ['id' => $service->id]) }}"
                        data-is-long="{{ $isLong }}"
                        data-is-premium="{{ $isPremium }}"
                    >
                        <!-- Glow highlight underlay -->
                        <div class="absolute -right-16 -top-16 h-36 w-36 rounded-full bg-brand-500/5 blur-2xl group-hover:bg-brand-500/15 transition-colors pointer-events-none"></div>

                        <div class="flex flex-col sm:flex-row gap-6">
                            <!-- Image/SVG container -->
                            <div class="w-full sm:w-44 shrink-0 aspect-[16/10] sm:aspect-square rounded-2xl overflow-hidden border border-white/5 bg-slate-950 relative">
                                @if (service_image_url($service->image_path))
                                    <img src="{{ service_image_url($service->image_path) }}" alt="{{ $service->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-xs text-slate-600 bg-white/5">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Text Details -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-500 bg-white/5 px-2.5 py-1 rounded-full border border-white/5">
                                            {{ $service->duration }} {{ __('min') }}
                                        </span>
                                        @if($service->price >= 80)
                                            <span class="text-[9px] font-bold uppercase tracking-wider text-brand-400 bg-brand-500/10 px-2.5 py-1 rounded-full border border-brand-500/10">
                                                Premium
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold tracking-tight text-white group-hover:text-brand-400 transition-colors">
                                        {{ $service->name }}
                                    </h3>
                                    <p class="text-xs text-slate-400 leading-relaxed line-clamp-2 font-sans">
                                        {{ $service->description ?: __('A premium service session configured to optimize operations.') }}
                                    </p>
                                </div>

                                <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                    <div>
                                        <span class="block text-[8px] font-bold uppercase text-slate-500">Rate</span>
                                        <span class="text-base font-extrabold text-white">${{ number_format((float) $service->price, 2) }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-brand-400 group-hover:text-brand-300 inline-flex items-center gap-1">
                                        Inspect Service <span>→</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="card text-center py-12 text-slate-500">
                        No services configured in catalog.
                    </div>
                @endforelse
            </div>

            <!-- Right: Service Spotlight Area (Inspector Panel) -->
            <div class="lg:col-span-5">
                <div class="inspector-panel space-y-6">
                    <div class="border-b border-white/5 pb-4">
                        <span class="inline-flex h-7 w-7 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center font-bold text-xs">★</span>
                        <h2 class="text-lg font-bold text-white mt-3" id="inspect-title">-</h2>
                        <span class="text-xs font-semibold text-slate-500 block mt-1" id="inspect-duration">-</span>
                    </div>

                    <!-- Media container -->
                    <div class="aspect-[16/10] w-full rounded-2xl overflow-hidden bg-slate-900 border border-white/5 relative" id="inspect-media-container">
                        <img src="" alt="" class="h-full w-full object-cover hidden" id="inspect-image">
                        <div class="absolute inset-0 flex items-center justify-center text-xs text-slate-500 font-semibold" id="inspect-no-image">
                            Preview Image
                            <svg class="h-6 w-6 text-slate-600 block mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="block text-[9px] font-bold uppercase text-slate-500 tracking-wider mb-1">Outline Details</span>
                            <p class="text-xs text-slate-300 leading-relaxed font-sans" id="inspect-desc">-</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 border-y border-white/5 py-4">
                            <div>
                                <span class="block text-[8px] font-bold uppercase text-slate-500">Duration</span>
                                <span class="text-sm font-bold text-white" id="inspect-duration-value">-</span>
                            </div>
                            <div>
                                <span class="block text-[8px] font-bold uppercase text-slate-500">Price Rate</span>
                                <span class="text-sm font-bold text-brand-400" id="inspect-price-value">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="" id="inspect-detail-btn" class="btn-secondary w-full justify-center bg-white/5 border-white/10 hover:border-white/20 text-white rounded-xl text-xs py-3 font-semibold">
                            Full Specs
                        </a>
                        <a href="" id="inspect-book-btn" class="btn-primary w-full justify-center bg-white text-slate-950 hover:bg-slate-100 border-none rounded-xl text-xs py-3 font-extrabold tracking-tight">
                            Reserve Slot
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pagination -->
        @if ($services->hasPages())
            <div class="flex justify-center border-t border-slate-800/80 pt-10 mt-10">
                <x-pagination :paginator="$services" />
            </div>
        @endif
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.service-item');
        
        // Spotlight elements
        const inspectTitle = document.getElementById('inspect-title');
        const inspectDuration = document.getElementById('inspect-duration');
        const inspectDurationValue = document.getElementById('inspect-duration-value');
        const inspectPriceValue = document.getElementById('inspect-price-value');
        const inspectDesc = document.getElementById('inspect-desc');
        const inspectImage = document.getElementById('inspect-image');
        const inspectNoImage = document.getElementById('inspect-no-image');
        const inspectDetailBtn = document.getElementById('inspect-detail-btn');
        const inspectBookBtn = document.getElementById('inspect-book-btn');

        // Function to populate inspector panel
        function populateInspector(el) {
            if (!el) return;
            // Remove active style from all elements
            items.forEach(i => i.classList.remove('bento-active'));
            
            // Add active style to selected element
            el.classList.add('bento-active');

            const name = el.getAttribute('data-name');
            const duration = el.getAttribute('data-duration');
            const price = el.getAttribute('data-price');
            const desc = el.getAttribute('data-desc');
            const img = el.getAttribute('data-img');
            const bookUrl = el.getAttribute('data-book-url');
            const detailUrl = el.getAttribute('data-detail-url');

            inspectTitle.textContent = name;
            inspectDuration.textContent = `${duration} session duration`;
            inspectDurationValue.textContent = duration;
            inspectPriceValue.textContent = price;
            inspectDesc.textContent = desc;

            if (img && img.trim() !== '') {
                inspectImage.src = img;
                inspectImage.classList.remove('hidden');
                inspectNoImage.classList.add('hidden');
            } else {
                inspectImage.classList.add('hidden');
                inspectNoImage.classList.remove('hidden');
            }

            if (detailUrl) {
                inspectDetailBtn.href = detailUrl;
                inspectDetailBtn.style.display = 'inline-flex';
            } else {
                inspectDetailBtn.style.display = 'none';
            }

            if (bookUrl) {
                inspectBookBtn.href = bookUrl;
                inspectBookBtn.style.display = 'inline-flex';
            } else {
                inspectBookBtn.style.display = 'none';
            }
        }

        // Initialize first service as active
        if (items.length > 0) {
            populateInspector(items[0]);
        }

        // Click updates inspector
        items.forEach(item => {
            item.addEventListener('click', () => {
                populateInspector(item);
            });
            // Also on hover/mouseenter for delightful responsive feedback
            item.addEventListener('mouseenter', () => {
                populateInspector(item);
            });
        });

        // HTML5 Canvas Floating Particles Network
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
            
            const container = document.getElementById('saas-services-container');
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

        // Live Filtering on Search & Category Chips
        const searchInput = document.getElementById('search-input');
        const filterBtns = document.querySelectorAll('#filter-bar button');
        
        let currentFilter = 'all';
        let searchQuery = '';

        function applyFilters() {
            let firstVisible = null;

            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                const desc = item.getAttribute('data-desc').toLowerCase();
                const isLong = item.getAttribute('data-is-long'); // 'long' or 'short'
                const isPremium = item.getAttribute('data-is-premium'); // 'premium' or 'budget'

                // Search match
                const matchesSearch = name.includes(searchQuery) || desc.includes(searchQuery);

                // Category match
                let matchesCategory = false;
                if (currentFilter === 'all') {
                    matchesCategory = true;
                } else if (currentFilter === 'short' && isLong === 'short') {
                    matchesCategory = true;
                } else if (currentFilter === 'long' && isLong === 'long') {
                    matchesCategory = true;
                } else if (currentFilter === 'premium' && isPremium === 'premium') {
                    matchesCategory = true;
                }

                if (matchesSearch && matchesCategory) {
                    item.style.display = 'block';
                    if (!firstVisible) {
                        firstVisible = item;
                    }
                } else {
                    item.style.display = 'none';
                }
            });

            // Update spotlight with the first visible filtered element
            if (firstVisible) {
                populateInspector(firstVisible);
            } else {
                // Clear inspector if nothing is found
                inspectTitle.textContent = "No Match Found";
                inspectDuration.textContent = "";
                inspectDurationValue.textContent = "-";
                inspectPriceValue.textContent = "-";
                inspectDesc.textContent = "Adjust your search parameters to discover other service templates.";
                inspectImage.classList.add('hidden');
                inspectNoImage.classList.remove('hidden');
                inspectDetailBtn.style.display = 'none';
                inspectBookBtn.style.display = 'none';
            }
        }

        // Search Input listener
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.toLowerCase().trim();
                applyFilters();
            });
        }

        // Category Chips listener
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active styling from all buttons
                filterBtns.forEach(b => {
                    b.className = "px-4 py-2 rounded-full text-xs font-semibold border border-white/5 bg-white/5 text-slate-300 transition-all hover:bg-white/10 hover:text-white cursor-pointer";
                });
                // Add active styling to clicked button
                btn.className = "px-4 py-2 rounded-full text-xs font-semibold border border-brand-500 bg-brand-500 text-white shadow-md shadow-brand-500/20 transition-all hover:opacity-90 cursor-pointer";
                
                currentFilter = btn.getAttribute('data-filter');
                applyFilters();
            });
        });
    });
</script>
@endpush
