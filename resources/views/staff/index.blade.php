@extends('layouts.app')

@section('title', 'Staff')

@section('content')
    <h1>Staff</h1>
    <p style="color: var(--muted); margin-top: 0;">Staff profiles linked to users and services.</p>
    <p><a href="{{ route('staff.create') }}" class="btn btn-primary">Add staff</a></p>

    <div class="card" style="margin-top: 1rem; padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User</th>
                    <th>Hours</th>
                    <th>Services</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffMembers as $member)
                    <tr>
                        <td><a href="{{ route('staff.show', $member) }}">{{ $member->full_name }}</a></td>
                        <td>{{ $member->user?->email ?? '—' }}</td>
                        <td>
                            @if ($member->start_time && $member->end_time)
                                {{ substr($member->start_time, 0, 5) }} – {{ substr($member->end_time, 0, 5) }}
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $member->services->count() }}</td>
                        <td class="actions">
                            <a href="{{ route('staff.edit', $member) }}">Edit</a>
                            <form action="{{ route('staff.destroy', $member) }}" method="post" style="display:inline;" onsubmit="return confirm('Remove this staff profile?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="color: var(--muted);">No staff yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $staffMembers->links() }}
    </div>
@endsection
