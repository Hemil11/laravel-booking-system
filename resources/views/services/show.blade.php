@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <h1>{{ $service->name }}</h1>
    <div class="card">
        @if ($service->image_path)
            <p style="margin: 0 0 1rem;">
                <img src="{{ media_url($service->image_path) }}" alt="" style="max-width: 100%; max-height: 280px; border-radius: 8px; border: 1px solid var(--border);">
            </p>
        @endif
        <p><strong>Duration:</strong> {{ $service->duration }} minutes</p>
        <p><strong>Price:</strong> {{ number_format((float) $service->price, 2) }}</p>
        <p class="actions" style="margin-top: 1rem;">
            <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('services.index') }}" class="btn btn-ghost">Back to list</a>
            <form action="{{ route('services.destroy', $service) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this service?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </p>
    </div>
@endsection
