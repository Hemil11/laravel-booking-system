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
<body class="@yield('body_class', 'min-h-screen bg-background text-text')">
    @yield('layout')

    @hasSection('layout')
    @else
        <main class="page-container section-wrap">
            @if (session('status'))
                <div class="mb-8 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    @endif

    @stack('scripts')
</body>
</html>
