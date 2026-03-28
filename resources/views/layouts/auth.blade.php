@extends('layouts.app')

@section('layout')
    <div class="flex min-h-screen flex-col bg-gradient-to-b from-gray-100 via-gray-50 to-indigo-50/50 text-text">
        <header class="shrink-0 border-b border-gray-200/90 bg-white/90 shadow-sm backdrop-blur-md">
            <div class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('frontend.home') }}" class="nav-brand">
                    <span class="nav-brand-mark">B</span>
                    <span>{{ config('app.name') }}</span>
                </a>
                <a
                    href="{{ route('frontend.home') }}"
                    class="text-sm font-medium text-gray-600 transition-colors hover:text-gray-900"
                >
                    {{ __('Back to home') }}
                </a>
            </div>
        </header>

        <main class="flex flex-1 flex-col items-center justify-center px-4 py-10 sm:px-6 sm:py-14">
            @if (session('status'))
                <div class="auth-shell mb-6 w-full">
                    <div class="alert-success" role="status">{{ session('status') }}</div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="shrink-0 border-t border-gray-200/80 bg-white/70 py-5 text-center backdrop-blur-sm">
            <p class="text-xs text-gray-500">
                &copy; {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
            </p>
        </footer>
    </div>
@endsection
