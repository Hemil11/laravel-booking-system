@extends('layouts.app')

@section('title', 'Services')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h1 class="page-title mb-1">Services</h1>
            <p class="page-subtitle mb-0">Manage bookable services and pricing.</p>
        </div>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Add service</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td><a href="{{ route('services.show', $service) }}">{{ $service->name }}</a></td>
                        <td>{{ $service->duration }} min</td>
                        <td>{{ number_format((float) $service->price, 2) }}</td>
                        <td class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('services.edit', $service) }}">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">No services yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $services->links() }}
    </div>
@endsection
