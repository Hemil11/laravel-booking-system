@extends('layouts.app')

@section('layout')
    <div class="flex min-h-screen flex-col bg-[#030508] text-white">
        <!-- Floating Glass Header -->
        <header class="shrink-0 border-b border-white/5 bg-[#030508]/80 backdrop-blur-xl">
            <div class="mx-auto flex h-20 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('frontend.home') }}" class="nav-brand">
                    <span class="nav-brand-mark">
                        <svg class="h-4 w-4 fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 22h20L12 2zm0 3.8L18.4 19H5.6L12 5.8z"/>
                        </svg>
                    </span>
                    <span class="font-display font-bold tracking-tight text-white">{{ config('app.name') }}</span>
                </a>
                <a
                    href="{{ route('frontend.home') }}"
                    class="text-xs font-semibold text-slate-400 hover:text-white transition-colors"
                >
                    {{ __('Back to Home') }}
                </a>
            </div>
        </header>

        <!-- Main Auth Body with background mesh glows -->
        <main class="flex flex-1 flex-col items-center justify-center px-4 py-12 sm:px-6 sm:py-16 relative overflow-hidden">
            <!-- Background glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-brand-500/10 rounded-full blur-[80px] pointer-events-none"></div>

            @if (session('status'))
                <div class="auth-shell mb-6 w-full relative z-10">
                    <div class="alert-success" role="status">{{ session('status') }}</div>
                </div>
            @endif

            <div class="relative z-10 w-full flex flex-col items-center">
                @yield('content')
            </div>
        </main>

        <footer class="shrink-0 border-t border-white/5 bg-[#030508]/40 py-6 text-center">
            <p class="text-xs text-slate-500">
                &copy; {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
            </p>
        </footer>
    </div>
@endsection
