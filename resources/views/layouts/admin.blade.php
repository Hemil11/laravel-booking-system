@extends('layouts.app')

@section('body_class', 'min-h-screen bg-[#030508] text-white antialiased')

@section('layout')
    @auth
        @php
            $user = auth()->user();
            $canManageUsers = $user->hasPermission('manage_users');
            $canManageServices = $user->hasPermission('manage_services');
            $canManageBookings = $user->hasPermission('manage_bookings');
            $adminHomeUrl = $canManageUsers ? route('admin.dashboard') : route('bookings.index');
        @endphp

        <div class="flex min-h-screen bg-[#030508] text-white">
            {{-- Mobile overlay --}}
            <div
                id="admin-sidebar-backdrop"
                class="fixed inset-0 z-40 hidden bg-black/80 backdrop-blur-sm transition-opacity lg:hidden"
                aria-hidden="true"
            ></div>

            {{-- Dark sidebar --}}
            <aside
                id="admin-sidebar"
                class="admin-sidebar bg-[#020306] border-r border-white/5"
                aria-label="{{ __('Admin navigation') }}"
            >
                <div class="admin-sidebar-brand border-b border-white/5 px-4 lg:px-5">
                    <a href="{{ $adminHomeUrl }}" class="flex min-w-0 flex-1 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-600 to-brand-400 text-sm font-extrabold text-white shadow-lg shadow-brand-500/20">A</span>
                        <span class="min-w-0 text-left">
                            <span class="block truncate text-sm font-bold text-white font-display">{{ config('app.name') }}</span>
                            <span class="block truncate text-xs text-slate-500 font-semibold">{{ __('Admin panel') }}</span>
                        </span>
                    </a>
                    <button
                        type="button"
                        id="admin-sidebar-close"
                        class="inline-flex shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/5 p-2 text-slate-300 transition hover:bg-white/10 hover:text-white lg:hidden"
                        aria-label="{{ __('Close menu') }}"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex flex-1 flex-col overflow-y-auto px-3 py-4" aria-label="{{ __('Primary') }}">
                    <p class="admin-sidebar-section-label">{{ __('Menu') }}</p>
                    <ul class="space-y-1">
                        @if ($canManageUsers)
                            <li>
                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    @class(['admin-sidebar-link', 'admin-sidebar-link-active' => request()->routeIs('admin.dashboard')])
                                >
                                    <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('admin.users.index') }}"
                                    @class(['admin-sidebar-link', 'admin-sidebar-link-active' => request()->routeIs('admin.users.*')])
                                >
                                    <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ __('Users') }}
                                </a>
                            </li>
                        @endif

                        @if ($canManageServices)
                            <li>
                                <a
                                    href="{{ route('services.index') }}"
                                    @class(['admin-sidebar-link', 'admin-sidebar-link-active' => request()->routeIs('services.*')])
                                >
                                    <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ __('Services') }}
                                </a>
                            </li>
                        @endif

                        <li>
                            <a
                                href="{{ route('bookings.index') }}"
                                @class(['admin-sidebar-link', 'admin-sidebar-link-active' => request()->routeIs('bookings.*')])
                            >
                                <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('Bookings') }}
                            </a>
                        </li>

                        @if ($canManageBookings)
                            <li>
                                <a
                                    href="{{ route('admin.invoices.index') }}"
                                    @class(['admin-sidebar-link', 'admin-sidebar-link-active' => request()->routeIs('admin.invoices.*')])
                                >
                                    <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ __('Invoices') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <div class="shrink-0 border-t border-white/5 p-3">
                    <a href="{{ route('frontend.home') }}" class="admin-sidebar-footer-link flex items-center gap-2 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-500 hover:bg-white/5 hover:text-white transition-colors">
                        <svg class="h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Back to site') }}
                    </a>
                </div>
            </aside>

            {{-- Main column: top navbar + content --}}
            <div class="flex min-w-0 flex-1 flex-col lg:min-h-screen">
                <header class="nav-admin-shell border-b border-white/5 bg-[#030508]/75 backdrop-blur-xl">
                    <div class="flex min-w-0 flex-1 items-center gap-3 sm:gap-4">
                        <button
                            type="button"
                            id="admin-sidebar-open"
                            class="inline-flex shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/5 p-2.5 text-slate-300 shadow-sm transition hover:bg-white/10 hover:text-white lg:hidden"
                            aria-label="{{ __('Open menu') }}"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="min-w-0">
                            <p class="truncate text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">{{ __('Admin') }}</p>
                            <h1 class="truncate text-base font-bold text-white font-display sm:text-lg">@yield('title', config('app.name'))</h1>
                        </div>
                    </div>

                    <details class="group relative shrink-0">
                        <summary class="flex cursor-pointer list-none items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-2 py-2 pr-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white shadow-md">
                                {{ strtoupper(substr((string) $user->name, 0, 1)) }}
                            </span>
                            <span class="hidden max-w-[9rem] truncate sm:inline">{{ $user->name }}</span>
                            <svg class="h-4 w-4 shrink-0 text-slate-400 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 z-50 mt-2 w-60 rounded-xl border border-white/10 bg-[#0c101c] p-2 shadow-2xl">
                            <div class="border-b border-white/5 px-3 py-2.5">
                                <p class="truncate text-sm font-bold text-white">{{ $user->name }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="mt-1 block rounded-lg px-3 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors">{{ __('Profile settings') }}</a>
                            <form action="{{ route('logout') }}" method="post" class="mt-1">
                                @csrf
                                <button type="submit" class="btn-secondary w-full !justify-start bg-transparent border-none text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Log out') }}</button>
                            </form>
                        </div>
                    </details>
                </header>

                <main class="flex-1 bg-[#030508] p-4 sm:p-6 lg:p-8">
                    <div class="rounded-3xl border border-white/5 bg-[#0c101c]/60 p-5 shadow-2xl backdrop-blur-md sm:p-6 lg:p-8">
                        @if (session('status'))
                            <div class="alert-success-rich mb-6 bg-green-500/10 border border-green-500/30 text-green-400" role="status" aria-live="polite">
                                <span class="mt-0.5 shrink-0 text-green-400" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <p class="min-w-0 flex-1 font-semibold leading-relaxed">{{ session('status') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert-danger mb-6 bg-red-500/10 border border-red-500/30 text-red-400" role="alert" aria-live="assertive">
                                <p class="mb-2 text-sm font-bold">{{ __('Please fix the following:') }}</p>
                                <ul class="list-inside list-disc space-y-1.5 text-xs font-semibold leading-relaxed">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        @push('scripts')
            <script>
                (function () {
                    var sidebar = document.getElementById('admin-sidebar');
                    var backdrop = document.getElementById('admin-sidebar-backdrop');
                    var openBtn = document.getElementById('admin-sidebar-open');
                    var closeBtn = document.getElementById('admin-sidebar-close');
                    if (!sidebar || !backdrop) return;

                    function openNav() {
                        sidebar.classList.add('is-open');
                        backdrop.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }

                    function closeNav() {
                        sidebar.classList.remove('is-open');
                        backdrop.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }

                    openBtn && openBtn.addEventListener('click', openNav);
                    closeBtn && closeBtn.addEventListener('click', closeNav);
                    backdrop.addEventListener('click', closeNav);

                    sidebar.querySelectorAll('a').forEach(function (link) {
                        link.addEventListener('click', function () {
                            if (window.matchMedia('(max-width: 1023px)').matches) closeNav();
                        });
                    });

                    window.addEventListener('resize', function () {
                        if (window.matchMedia('(min-width: 1024px)').matches) {
                            sidebar.classList.remove('is-open');
                            backdrop.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }
                    });
                })();
            </script>
        @endpush
    @else
        <div class="flex min-h-screen items-center justify-center bg-[#030508] p-6">
            <div class="max-w-md rounded-3xl border border-white/5 bg-[#0d1324]/50 p-8 text-center shadow-2xl backdrop-blur-md">
                <p class="text-slate-400 font-semibold">
                    <a href="{{ route('login') }}" class="link font-bold text-white hover:underline">{{ __('Sign in') }}</a>
                    {{ __('to access the admin panel.') }}
                </p>
            </div>
        </div>
    @endauth
@endsection
