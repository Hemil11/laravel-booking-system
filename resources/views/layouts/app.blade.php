<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @stack('head')
</head>
<body class="@yield('body_class', 'min-h-screen bg-[#030508] text-white antialiased')">
    @yield('layout')

    @hasSection('layout')
    @else
        <main class="page-container section-wrap">
            <div class="rounded-[2rem] border border-white/5 bg-[#0d1324]/50 p-6 sm:p-8 shadow-2xl backdrop-blur-md lg:p-10">
                @if (session('status'))
                    <div class="alert-success mb-8 bg-green-500/10 border border-green-500/30 text-green-400" role="status">
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
