@extends('layouts.app')

@section('body_class', 'min-h-screen bg-gray-100 text-gray-900 antialiased')

@section('layout')
    @auth
        @php
            $user = auth()->user();
            $canManageUsers = $user->hasPermission('manage_users');
            $canManageServices = $user->hasPermission('manage_services');
            $canManageBookings = $user->hasPermission('manage_bookings');
            $adminHomeUrl = $canManageUsers ? route('admin.dashboard') : route('bookings.index');

            $navLink = function (bool $active) {
                $base = 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors';

                return $base.($active
                    ? ' bg-gray-800 text-white shadow-sm ring-1 ring-white/10'
                    : ' text-gray-300 hover:bg-gray-800/80 hover:text-white');
            };
        @endphp

        <div class="flex min-h-screen">
            {{-- Mobile overlay --}}
            <div
                id="admin-sidebar-backdrop"
                class="fixed inset-0 z-40 hidden bg-gray-900/60 backdrop-blur-sm lg:hidden"
                aria-hidden="true"
            ></div>

            {{-- Sidebar --}}
            <aside
                id="admin-sidebar"
                class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-gray-800 bg-gray-900 transition-transform duration-200 ease-out lg:relative lg:z-0 lg:translate-x-0"
                aria-label="Admin navigation"
            >
                <div class="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-gray-800 px-4 lg:h-[4.25rem]">
                    <a href="{{ $adminHomeUrl }}" class="flex items-center gap-2 truncate">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white shadow-lg shadow-indigo-900/40">A</span>
                        <span class="truncate">
                            <span class="block truncate text-sm font-semibold text-white">{{ config('app.name') }}</span>
                            <span class="block truncate text-xs text-gray-400">Admin</span>
                        </span>
                    </a>
                    <button
                        type="button"
                        id="admin-sidebar-close"
                        class="btn-secondary !border-gray-600 !p-2 !text-gray-300 hover:!border-gray-500 hover:!bg-gray-800 hover:!text-white lg:hidden"
                        aria-label="Close menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                    @if ($canManageUsers)
                        <a href="{{ route('admin.dashboard') }}" class="{{ $navLink(request()->routeIs('admin.dashboard')) }}">
                            <svg class="h-5 w-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="{{ $navLink(request()->routeIs('admin.users.*')) }}">
                            <svg class="h-5 w-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Users
                        </a>
                    @endif

                    @if ($canManageServices)
                        <a href="{{ route('services.index') }}" class="{{ $navLink(request()->routeIs('services.*')) }}">
                            <svg class="h-5 w-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Services
                        </a>
                    @endif

                    <a href="{{ route('bookings.index') }}" class="{{ $navLink(request()->routeIs('bookings.*')) }}">
                        <svg class="h-5 w-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Bookings
                    </a>

                    @if ($canManageBookings)
                        <a href="{{ route('admin.invoices.index') }}" class="{{ $navLink(request()->routeIs('admin.invoices.*')) }}">
                            <svg class="h-5 w-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Invoices
                        </a>
                    @endif
                </nav>

                <div class="shrink-0 border-t border-gray-800 p-3">
                    <a href="{{ route('frontend.home') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs font-medium text-gray-400 transition-colors hover:bg-gray-800 hover:text-gray-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to site
                    </a>
                </div>
            </aside>

            {{-- Main column --}}
            <div class="flex min-w-0 flex-1 flex-col">
                <header class="nav-admin-shell">
                    <div class="flex min-w-0 items-center gap-4">
                        <button
                            type="button"
                            id="admin-sidebar-open"
                            class="btn-secondary !border-gray-200 !p-2 !text-gray-600 hover:!bg-gray-50 lg:hidden"
                            aria-label="Open menu"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="min-w-0">
                            <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-500">Admin</p>
                            <p class="truncate text-sm font-semibold text-gray-900">@yield('title', config('app.name'))</p>
                        </div>
                    </div>

                    <details class="group relative">
                        <summary class="flex cursor-pointer list-none items-center gap-2.5 rounded-xl border border-gray-200/90 bg-gray-50/90 px-2.5 py-2 pr-3 text-sm font-medium text-gray-800 shadow-sm backdrop-blur-sm transition hover:border-gray-300 hover:bg-white">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">
                                {{ strtoupper(substr((string) $user->name, 0, 1)) }}
                            </span>
                            <span class="hidden max-w-[10rem] truncate sm:inline">{{ $user->name }}</span>
                            <svg class="h-4 w-4 shrink-0 text-gray-500 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-56 rounded-xl border border-gray-200/90 bg-white/95 p-1.5 shadow-xl shadow-gray-900/10 ring-1 ring-black/5 backdrop-blur-xl">
                            <div class="border-b border-gray-100 px-3 py-2">
                                <p class="truncate text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile settings</a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn-secondary mt-0.5 w-full !justify-start">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </details>
                </header>

                <main class="flex-1 bg-gray-100 p-4 sm:p-6 lg:p-8">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-md ring-1 ring-black/5 sm:p-6 lg:p-8">
                        @if (session('status'))
                            <div class="alert-success-rich mb-6" role="status">
                                <span class="mt-0.5 shrink-0 text-green-600" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <p class="min-w-0 flex-1 font-medium leading-relaxed">{{ session('status') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert-danger mb-6" role="alert">
                                <p class="mb-2 font-semibold">{{ __('Something needs your attention') }}</p>
                                <ul class="list-inside list-disc space-y-1 font-medium">
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
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        backdrop.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }

                    function closeNav() {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
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
                            backdrop.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        }
                    });
                })();
            </script>
        @endpush
    @else
        <div class="flex min-h-screen items-center justify-center bg-gray-100 p-6">
            <div class="max-w-md rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-md ring-1 ring-black/5">
                <p class="text-gray-600">
                    <a href="{{ route('login') }}" class="link font-semibold">Sign in</a> to access the admin panel.
                </p>
            </div>
        </div>
    @endauth
@endsection
