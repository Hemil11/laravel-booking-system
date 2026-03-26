<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <style>
        :root {
            --bg: #f7f9fc;
            --panel: #ffffff;
            --border: #e4e9f2;
            --text: #0f172a;
            --muted: #64748b;
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color: var(--text); background: var(--bg); }
        a { color: var(--brand); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .container { width: min(1100px, 92%); margin: 0 auto; }
        .site-header { position: sticky; top: 0; z-index: 20; background: rgba(247, 249, 252, 0.96); border-bottom: 1px solid var(--border); backdrop-filter: blur(8px); }
        .site-header-inner { display: flex; gap: 1rem; align-items: center; justify-content: space-between; padding: 0.9rem 0; }
        .brand { font-weight: 700; font-size: 1.05rem; color: var(--text); }
        .nav { display: flex; gap: 0.85rem; align-items: center; flex-wrap: wrap; }
        .nav a { color: #334155; font-size: 0.95rem; font-weight: 500; }
        .btn { border: 1px solid transparent; border-radius: 10px; padding: 0.58rem 1rem; font-size: 0.92rem; font-weight: 600; cursor: pointer; display: inline-block; }
        .btn-primary { background: var(--brand); color: #fff; }
        .btn-primary:hover { background: var(--brand-dark); text-decoration: none; }
        .btn-outline { border-color: var(--border); color: #334155; background: #fff; }
        .btn-outline:hover { text-decoration: none; border-color: #cbd5e1; }
        .hero { padding: 4rem 0 3rem; }
        .hero-grid { display: grid; grid-template-columns: 1.25fr 1fr; gap: 2rem; align-items: center; }
        .hero h1 { margin: 0 0 0.8rem; font-size: clamp(1.8rem, 4vw, 3rem); line-height: 1.12; letter-spacing: -0.02em; }
        .hero p { margin: 0 0 1.1rem; color: var(--muted); font-size: 1rem; max-width: 60ch; }
        .hero-card, .card { background: var(--panel); border: 1px solid var(--border); border-radius: 14px; padding: 1.15rem; }
        .section { padding: 1.2rem 0 2.1rem; }
        .section-title { margin: 0 0 0.9rem; font-size: 1.45rem; }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
        .service-card h3 { margin: 0 0 0.5rem; font-size: 1.05rem; }
        .service-meta { color: var(--muted); font-size: 0.92rem; }
        .flash { margin: 1rem 0; padding: 0.8rem 1rem; border-radius: 10px; border: 1px solid #a7f3d0; background: #ecfdf5; color: #065f46; }
        .form-field { margin-bottom: 0.95rem; }
        .form-field label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem; }
        .form-field input, .form-field select, .form-field textarea { width: 100%; border: 1px solid var(--border); border-radius: 10px; padding: 0.56rem 0.68rem; font-size: 0.96rem; background: #fff; }
        .form-field textarea { min-height: 100px; resize: vertical; }
        .error { color: #dc2626; font-size: 0.82rem; margin-top: 0.3rem; }
        .site-footer { border-top: 1px solid var(--border); margin-top: 2rem; padding: 1.2rem 0 2rem; color: var(--muted); font-size: 0.9rem; }
        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; }
            .grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
            .site-header-inner { align-items: flex-start; flex-direction: column; }
        }
    </style>
    @stack('head')
</head>
<body>
    <header class="site-header">
        <div class="container site-header-inner">
            <a href="{{ route('frontend.home') }}" class="brand">{{ config('app.name') }}</a>
            <nav class="nav">
                <a href="{{ route('frontend.home') }}">Home</a>
                <a href="{{ route('frontend.services') }}">Services</a>
                <a href="{{ route('frontend.book') }}">Book appointment</a>
                <a href="{{ route('frontend.contact') }}">Contact</a>
                @auth
                    <a href="{{ route('bookings.index') }}">My bookings</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">Modern booking experience built with Laravel.</div>
    </footer>
    @stack('scripts')
</body>
</html>
