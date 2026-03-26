@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <h1 class="page-title">{{ $service->name }}</h1>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
        @if ($service->image_path)
            <p class="mb-3">
                <img src="{{ media_url($service->image_path) }}" alt="" class="img-fluid rounded border">
            </p>
        @endif
        <div class="row g-2">
            <div class="col-md-6"><strong>Duration:</strong> {{ $service->duration }} minutes</div>
            <div class="col-md-6"><strong>Price:</strong> {{ number_format((float) $service->price, 2) }}</div>
        </div>
        <p class="d-flex gap-2 flex-wrap mt-3 mb-0">
            <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Back to list</a>
            <form action="{{ route('services.destroy', $service) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this service?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </p>
        </div>
    </div>
@endsection
