@extends('layouts.app')

@section('title', $staff->full_name)

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">{{ $staff->full_name }}</h1>
        <p class="mt-2 text-small text-text-muted">Staff profile details, schedule, and linked services.</p>
    </div>
    <div class="card">
        <div class="space-y-3">
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
        </div>
        @if ($staff->bio)
            <p class="mt-3"><strong>Bio:</strong><br>{{ $staff->bio }}</p>
        @endif

        <h2 class="mb-2 mt-6 text-h3 text-text">Services</h2>
        @if ($staff->services->isEmpty())
            <p class="text-text-muted">No services assigned.</p>
        @else
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($staff->services as $service)
                    <li>{{ $service->name }} — {{ $service->duration }} min, {{ number_format((float) $service->price, 2) }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mt-6 flex flex-wrap gap-2">
            <x-button href="{{ route('staff.edit', $staff) }}">Edit</x-button>
            <x-button variant="outline" href="{{ route('staff.index') }}">Back to list</x-button>
            <form action="{{ route('staff.destroy', $staff) }}" method="post" class="inline" onsubmit="return confirm('Remove this staff profile?');">
                @csrf
                @method('DELETE')
                <x-button class="!bg-danger hover:!bg-red-700" type="submit">Delete</x-button>
            </form>
        </div>
    </div>
@endsection
