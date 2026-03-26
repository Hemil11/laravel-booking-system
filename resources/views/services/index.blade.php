@extends('layouts.app')

@section('title', 'Services')

@section('content')
    <h1>Services</h1>
    <p style="color: var(--muted); margin-top: 0;">Manage bookable services.</p>
    <p><a href="{{ route('services.create') }}" class="btn btn-primary">Add service</a></p>

    <div class="card" style="margin-top: 1rem; padding: 0;">
        <table>
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
                        <td class="actions">
                            <a href="{{ route('services.edit', $service) }}">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="color: var(--muted);">No services yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $services->links() }}
    </div>
@endsection
