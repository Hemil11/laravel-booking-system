@extends('layouts.admin')

@section('title', 'Staff')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-h1 text-text">Staff</h1>
            <p class="mt-1 text-small text-text-muted">Staff profiles linked to users and services.</p>
        </div>
        <x-button href="{{ route('staff.create') }}">Add staff</x-button>
    </div>

    <x-card class="mb-4" header="Search staff">
        <form method="get" class="grid gap-3 sm:grid-cols-[1fr_auto_auto]">
            <x-form.input name="search" label="Keyword" :value="$search ?? ''" placeholder="Name, user, or email..." />
            <div class="self-end">
                <x-button type="submit">Search</x-button>
            </div>
            <div class="self-end">
                <x-button variant="outline" href="{{ route('staff.index') }}">Reset</x-button>
            </div>
        </form>
    </x-card>

    <x-table>
        <x-slot:head>
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">User</th>
            <th class="px-4 py-3">Hours</th>
            <th class="px-4 py-3">Services</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Actions</th>
        </x-slot:head>

        @forelse ($staffMembers as $member)
            <tr>
                <td class="px-4 py-3 font-medium">
                    <a href="{{ route('staff.show', $member) }}" class="text-indigo-700 hover:underline">{{ $member->full_name }}</a>
                </td>
                <td class="px-4 py-3">{{ $member->user?->email ?? '—' }}</td>
                <td class="px-4 py-3">
                    @if ($member->start_time && $member->end_time)
                        {{ substr($member->start_time, 0, 5) }} - {{ substr($member->end_time, 0, 5) }}
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-3">{{ $member->services->count() }}</td>
                <td class="px-4 py-3">
                    <x-badge :status="$member->is_active ? 'active' : 'inactive'" />
                </td>
                <x-table.actions>
                    <x-table.action variant="view" href="{{ route('staff.show', $member) }}" />
                    <x-table.action variant="edit" href="{{ route('staff.edit', $member) }}" />
                    <x-table.action
                        variant="delete"
                        :form-action="route('staff.destroy', $member)"
                        :confirm="__('Remove this staff profile?')"
                    />
                </x-table.actions>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-text-subtle">No staff found.</td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination class="mt-8" :paginator="$staffMembers" />
@endsection
