<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage_staff'])->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $staffMembers = Staff::query()
            ->with(['user', 'services'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('full_name', 'like', '%'.$search.'%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staff.index', compact('staffMembers', 'search'));
    }

    public function create(): View
    {
        return view('staff.create', [
            'users' => $this->usersAvailableForStaff(),
            'services' => Service::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $serviceIds = $data['services'] ?? [];
        unset($data['services']);

        $staff = Staff::query()->create($data);
        $staff->services()->sync($this->pivotForServices($serviceIds));

        return redirect()
            ->route('staff.index')
            ->with('status', __('Staff member created successfully.'));
    }

    public function show(Staff $staff): View
    {
        $staff->load(['user', 'services']);

        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff): View
    {
        return view('staff.edit', [
            'staff' => $staff->load(['services']),
            'users' => $this->usersAvailableForStaff($staff),
            'services' => Service::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateStaffRequest $request, Staff $staff): RedirectResponse
    {
        $data = $request->validated();
        $serviceIds = $data['services'] ?? [];
        unset($data['services']);

        $staff->update($data);
        $staff->services()->sync($this->pivotForServices($serviceIds));

        return redirect()
            ->route('staff.show', $staff)
            ->with('status', __('Staff member updated successfully.'));
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('status', __('Staff member removed successfully.'));
    }

    /**
     * @return Collection<int, User>
     */
    private function usersAvailableForStaff(?Staff $except = null)
    {
        return User::query()
            ->when($except, function ($q) use ($except) {
                $q->where(function ($q2) use ($except) {
                    $q2->whereDoesntHave('staffProfile')
                        ->orWhere('id', $except->user_id);
                });
            }, fn ($q) => $q->whereDoesntHave('staffProfile'))
            ->orderBy('name')
            ->get();
    }

    /**
     * @param  array<int, int|string>  $serviceIds
     * @return array<int, array<string, mixed>>
     */
    private function pivotForServices(array $serviceIds): array
    {
        $sync = [];
        foreach ($serviceIds as $id) {
            $sync[(int) $id] = [
                'is_active' => true,
                'price_override_cents' => null,
                'currency' => null,
            ];
        }

        return $sync;
    }
}
