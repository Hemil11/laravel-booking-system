@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">{{ $service->name }}</h1>
        <p class="mt-2 text-small text-text-muted">Service details and management actions.</p>
    </div>
    <div class="card space-y-6">
        @if ($service->image_path)
            <img src="{{ media_url($service->image_path) }}" alt="" class="max-h-72 w-auto rounded-xl border border-border object-cover shadow-sm">
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            <div><span class="text-small text-text-muted">Duration</span><p class="font-semibold text-text">{{ $service->duration }} minutes</p></div>
            <div><span class="text-small text-text-muted">Price</span><p class="font-semibold text-text">{{ number_format((float) $service->price, 2) }}</p></div>
        </div>

        <div class="flex flex-wrap gap-2 border-t border-border pt-4">
            <x-button href="{{ route('services.edit', $service) }}">Edit</x-button>
            <x-button variant="outline" href="{{ route('services.index') }}">Back to list</x-button>
            <form action="{{ route('services.destroy', $service) }}" method="post" class="inline" onsubmit="return confirm('Delete this service?');">
                @csrf
                @method('DELETE')
                <x-button class="!bg-danger hover:!bg-red-700" type="submit">Delete</x-button>
            </form>
        </div>
    </div>
@endsection
