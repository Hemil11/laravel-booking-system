@extends('layouts.app')

@section('title', $staff->full_name)

@section('content')
    <h1>{{ $staff->full_name }}</h1>
    <div class="card">
        <p><strong>Linked user:</strong> {{ $staff->user?->name }} ({{ $staff->user?->email ?? '—' }})</p>
        <p><strong>Phone:</strong> {{ $staff->phone ?: '—' }}</p>
        <p><strong>Working hours:</strong>
            @if ($staff->start_time && $staff->end_time)
                {{ substr($staff->start_time, 0, 5) }} – {{ substr($staff->end_time, 0, 5) }}
            @else
                —
            @endif
        </p>
        <p><strong>Status:</strong> {{ $staff->is_active ? __('Active') : __('Inactive') }}</p>
        @if ($staff->bio)
            <p><strong>Bio:</strong><br>{{ $staff->bio }}</p>
        @endif

        <h2 style="font-size: 1.1rem; margin: 1.25rem 0 0.5rem;">Services</h2>
        @if ($staff->services->isEmpty())
            <p style="color: var(--muted);">No services assigned.</p>
        @else
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($staff->services as $service)
                    <li>{{ $service->name }} — {{ $service->duration }} min, {{ number_format((float) $service->price, 2) }}</li>
                @endforeach
            </ul>
        @endif

        <p class="actions" style="margin-top: 1.25rem;">
            <a href="{{ route('staff.edit', $staff) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('staff.index') }}" class="btn btn-ghost">Back to list</a>
            <form action="{{ route('staff.destroy', $staff) }}" method="post" style="display:inline;" onsubmit="return confirm('Remove this staff profile?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </p>
    </div>
@endsection
