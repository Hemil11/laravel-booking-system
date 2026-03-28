<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @stack('head')
</head>
<body class="@yield('body_class', 'min-h-screen bg-gray-100 text-text')">
    @yield('layout')

    @hasSection('layout')
    @else
        <main class="page-container section-wrap">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md ring-1 ring-gray-900/5 sm:p-8 lg:p-10">
                @if (session('status'))
                    <div class="alert-success mb-8" role="status">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    @endif

    @stack('scripts')
</body>
</html>
