@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ __('Users') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('Accounts, roles, and verification.') }}</p>
        </div>
        <x-button href="{{ route('admin.users.create') }}">{{ __('Add user') }}</x-button>
    </div>

    <x-filter.resource-bar
        class="mb-6"
        :title="__('Filter users')"
        :reset-url="route('admin.users.index')"
        :filters="$filters"
        :status-options="$statusOptions"
        :status-allows-any="true"
        :status-any-label="__('Any verification')"
        :status-label="__('Verification')"
        :search-placeholder="__('Name or email…')"
        :date-from-label="__('Registered from')"
        :date-to-label="__('Registered to')"
    />

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <x-bulk.form
            :action="route('admin.users.bulk')"
            :status-options="$bulkStatusOptions"
            :delete-confirm="__('Permanently delete selected users? This cannot be undone. Users with related data may fail to delete.')"
            delete-label="{{ __('Delete selected') }}"
        >
            <x-table>
                <x-slot:head>
                    <th class="w-12 px-3 py-3 text-left">
                        <input
                            type="checkbox"
                            data-bulk-select-all
                            class="checkbox"
                            aria-label="{{ __('Select all on this page') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Verification</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Roles') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Actions') }}</th>
                </x-slot:head>

                @forelse ($users as $user)
                    <tr>
                        <td class="px-3 py-3 align-middle">
                            @if ($user->id === auth()->id())
                                <span class="inline-block h-4 w-4 rounded border border-dashed border-gray-300 bg-white" title="{{ __('Your account') }}" aria-hidden="true"></span>
                            @else
                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="{{ $user->id }}"
                                    data-bulk-row
                                    class="checkbox"
                                    aria-label="{{ __('Select :name', ['name' => $user->name]) }}"
                                />
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if ($user->email_verified_at)
                                <x-badge status="confirmed">{{ __('Verified') }}</x-badge>
                            @else
                                <x-badge status="pending">{{ __('Unverified') }}</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @forelse ($user->roles as $role)
                                    <span class="inline-flex rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-800 ring-1 ring-inset ring-indigo-600/20">{{ $role->name }}</span>
                                @empty
                                    <span class="text-xs text-gray-400">—</span>
                                @endforelse
                            </div>
                        </td>
                        <x-table.actions>
                            <x-table.action variant="edit" href="{{ route('admin.users.edit', $user) }}" />
                        </x-table.actions>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">{{ __('No users found.') }}</td>
                    </tr>
                @endforelse
            </x-table>
        </x-bulk.form>
    </div>

    <x-pagination class="mt-8" :paginator="$users" />
@endsection
