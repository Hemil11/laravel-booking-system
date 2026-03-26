<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <style>
        :root { --bg: #f8fafc; --card: #fff; --border: #e2e8f0; --text: #0f172a; --muted: #64748b; --accent: #2563eb; --danger: #dc2626; }
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; background: var(--bg); color: var(--text); line-height: 1.5; }
        .wrap { max-width: 960px; margin: 0 auto; padding: 1.5rem; }
        header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
        header a { color: var(--accent); text-decoration: none; font-weight: 500; }
        header a:hover { text-decoration: underline; }
        h1 { font-size: 1.5rem; font-weight: 600; margin: 0 0 1rem; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 1.25rem; }
        .btn { display: inline-block; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { filter: brightness(1.05); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-danger { background: var(--danger); color: #fff; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th, td { text-align: left; padding: 0.65rem 0.5rem; border-bottom: 1px solid var(--border); }
        th { color: var(--muted); font-weight: 500; }
        .flash { padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.35rem; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="date"], input[type="time"], select, textarea { width: 100%; max-width: 420px; padding: 0.5rem 0.65rem; border: 1px solid var(--border); border-radius: 6px; font-size: 1rem; }
        textarea { max-width: 100%; min-height: 80px; resize: vertical; }
        select[multiple] { max-width: 100%; min-height: 120px; }
        .field { margin-bottom: 1rem; }
        .error { color: var(--danger); font-size: 0.8125rem; margin-top: 0.25rem; }
        .actions { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; }
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <strong><a href="{{ url('/') }}">{{ config('app.name') }}</a></strong>
            <nav class="actions">
                @auth
                    <a href="{{ route('bookings.index') }}">Bookings</a>
                    <a href="{{ route('bookings.create') }}">New booking</a>
                @endauth
                <a href="{{ route('services.index') }}">Services</a>
                <a href="{{ route('services.create') }}">New service</a>
                <a href="{{ route('staff.index') }}">Staff</a>
                <a href="{{ route('staff.create') }}">New staff</a>
                @auth
                    <form action="{{ route('logout') }}" method="post" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost" style="padding: 0.35rem 0.75rem;">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                @endauth
            </nav>
        </header>
        @if (session('status'))
            <div class="flash" role="status">{{ session('status') }}</div>
        @endif
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
