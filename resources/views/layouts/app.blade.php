<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .app-shell { min-height: calc(100vh - 56px); }
        .app-sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #e9ecef;
        }
        .app-sidebar .nav-link {
            color: #334155;
            border-radius: 0.5rem;
            padding: 0.55rem 0.75rem;
            font-weight: 500;
        }
        .app-sidebar .nav-link:hover,
        .app-sidebar .nav-link.active {
            background: #eef2ff;
            color: #1d4ed8;
        }
        .content-wrap { width: 100%; }
        .page-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        .page-subtitle { color: #64748b; margin-bottom: 1rem; }
        @media (max-width: 991.98px) {
            .app-sidebar { width: 100%; border-right: 0; border-bottom: 1px solid #e9ecef; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appTopNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="appTopNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Log out</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('login') }}">Log in</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-lg-flex app-shell">
        <aside class="app-sidebar p-3">
            <ul class="nav nav-pills flex-column gap-1">
                @auth
                    @if (auth()->user()->hasPermission('manage_users'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('bookings.create') }}">Book Appointment</a></li>
                @endauth
                <li class="nav-item"><a class="nav-link" href="{{ route('services.index') }}">Services</a></li>
                @auth
                    @if (auth()->user()->hasPermission('manage_services'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('services.create') }}">New Service</a></li>
                    @endif
                @endauth
                <li class="nav-item"><a class="nav-link" href="{{ route('staff.index') }}">Staff</a></li>
                @auth
                    @if (auth()->user()->hasPermission('manage_staff'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('staff.create') }}">New Staff</a></li>
                    @endif
                @endauth
            </ul>
        </aside>

        <div class="content-wrap p-3 p-lg-4">
            @if (session('status'))
                <div class="alert alert-success" role="status">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
