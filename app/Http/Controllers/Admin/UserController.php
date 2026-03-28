<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminUserRequest;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage_users']);
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', Rule::in(['', 'verified', 'unverified'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $statusFilter = ($validated['status'] ?? '') !== '' ? $validated['status'] : null;
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $users = User::query()
            ->with('roles')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($statusFilter === 'verified', fn ($query) => $query->whereNotNull('email_verified_at'))
            ->when($statusFilter === 'unverified', fn ($query) => $query->whereNull('email_verified_at'))
            ->when($dateFrom, fn ($query) => $query->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('created_at', '<=', $dateTo))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $filters = [
            'search' => $search,
            'status' => $statusFilter,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];

        $statusOptions = [
            'verified' => __('Verified email'),
            'unverified' => __('Unverified email'),
        ];

        $bulkStatusOptions = [
            'verified' => __('Mark email verified'),
            'unverified' => __('Mark email unverified'),
        ];

        return view('admin.users.index', compact('users', 'filters', 'statusOptions', 'bulkStatusOptions'));
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => $request->boolean('email_verified') ? now() : null,
        ]);

        $user->roles()->sync($data['role_ids'] ?? []);

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User created successfully.'));
    }

    public function edit(User $user): View
    {
        $user->load('roles');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::query()->orderBy('name')->get(),
            'canEditRoles' => ! $user->is(request()->user()),
        ]);
    }

    public function update(UpdateAdminUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => $request->boolean('email_verified') ? now() : null,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();

        if (! $user->is($request->user())) {
            $user->roles()->sync($data['role_ids'] ?? []);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User updated successfully.'));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => __('You cannot delete your own account.')]);
        }

        try {
            $user->delete();
        } catch (\Throwable) {
            return back()->withErrors(['user' => __('This user could not be deleted. They may still have related records.')]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('status', __('User deleted successfully.'));
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bulk_action' => ['required', 'string', Rule::in(['delete', 'set_status'])],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:users,id'],
            'status_value' => ['nullable', 'string', Rule::in(['verified', 'unverified'])],
        ]);

        $ids = array_values(array_unique(array_map('intval', $validated['ids'])));
        $authId = (int) $request->user()->id;
        $ids = array_values(array_filter($ids, fn (int $id) => $id !== $authId));

        if ($ids === []) {
            return back()->withErrors(['ids' => __('You cannot perform this action on your own account.')]);
        }

        $users = User::query()->whereIn('id', $ids)->get();

        if ($users->count() !== count($ids)) {
            return back()->withErrors(['ids' => __('Invalid selection.')]);
        }

        $affected = 0;
        $failed = 0;

        if ($validated['bulk_action'] === 'delete') {
            foreach ($users as $user) {
                try {
                    $user->delete();
                    $affected++;
                } catch (\Throwable) {
                    $failed++;
                }
            }

            $message = __('Deleted :n user(s).', ['n' => $affected]);
            if ($failed > 0) {
                $message .= ' '.__(':m could not be removed (dependencies may exist).', ['m' => $failed]);
            }

            return back()->with('status', $message);
        }

        $statusValue = $validated['status_value'] ?? '';
        if ($statusValue === '') {
            return back()->withErrors(['status_value' => __('Choose verified or unverified.')]);
        }

        foreach ($users as $user) {
            if ($statusValue === 'verified') {
                if ($user->email_verified_at === null) {
                    $user->forceFill(['email_verified_at' => now()])->save();
                    $affected++;
                }
            } elseif ($statusValue === 'unverified') {
                if ($user->email_verified_at !== null) {
                    $user->forceFill(['email_verified_at' => null])->save();
                    $affected++;
                }
            }
        }

        return back()->with('status', __('Updated :n user(s).', ['n' => $affected]));
    }
}
