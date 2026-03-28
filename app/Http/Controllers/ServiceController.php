<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\Media\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {
        $this->middleware(['auth', 'permission:manage_services'])->only(['create', 'store', 'edit', 'update', 'destroy', 'bulk']);
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', Rule::in(['active', 'archived', 'all'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $status = $validated['status'] ?? 'active';
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $baseQuery = match ($status) {
            'archived' => Service::onlyTrashed(),
            'all' => Service::withTrashed(),
            default => Service::query(),
        };

        $services = $baseQuery
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                });
            })
            ->when($dateFrom, fn ($query) => $query->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('created_at', '<=', $dateTo))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $filters = [
            'search' => $search,
            'status' => $status,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];

        $statusOptions = [
            'active' => __('Active'),
            'archived' => __('Archived'),
            'all' => __('All (including archived)'),
        ];

        $bulkStatusOptions = [
            'restore' => __('Restore (active)'),
            'archive' => __('Archive'),
        ];

        return view('services.index', compact('services', 'filters', 'statusOptions', 'bulkStatusOptions'));
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bulk_action' => ['required', 'string', Rule::in(['delete', 'set_status'])],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'status_value' => ['nullable', 'string', Rule::in(['restore', 'archive'])],
        ]);

        $ids = array_values(array_unique(array_map('intval', $validated['ids'])));
        $services = Service::withTrashed()->whereIn('id', $ids)->get();

        if ($services->count() !== count($ids)) {
            return back()->withErrors(['ids' => __('Invalid selection.')]);
        }

        $affected = 0;

        if ($validated['bulk_action'] === 'delete') {
            foreach ($services as $service) {
                if (! $service->trashed()) {
                    $this->fileUploadService->delete($service->image_path);
                    $service->delete();
                    $affected++;
                }
            }

            return back()->with('status', __('Archived :n service(s).', ['n' => $affected]));
        }

        $statusValue = $validated['status_value'] ?? '';
        if ($statusValue === '') {
            return back()->withErrors(['status_value' => __('Choose restore or archive.')]);
        }

        if ($statusValue === 'archive') {
            foreach ($services as $service) {
                if (! $service->trashed()) {
                    $this->fileUploadService->delete($service->image_path);
                    $service->delete();
                    $affected++;
                }
            }
        }

        if ($statusValue === 'restore') {
            foreach ($services as $service) {
                if ($service->trashed()) {
                    $service->restore();
                    $affected++;
                }
            }
        }

        return back()->with('status', __('Updated :n service(s).', ['n' => $affected]));
    }

    public function create(): View
    {
        return view('services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = Service::query()->create($request->safe()->only(['name', 'description', 'duration', 'price']));

        if ($request->hasFile('image')) {
            $service->update([
                'image_path' => $this->fileUploadService->store(
                    $request->file('image'),
                    'services/'.$service->id
                ),
            ]);
        }

        return redirect()
            ->route('services.index')
            ->with('status', __('Service created successfully.'));
    }

    public function edit(Service $service): View
    {
        return view('services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->safe()->only(['name', 'description', 'duration', 'price']));

        if ($request->hasFile('image')) {
            $this->fileUploadService->delete($service->image_path);
            $service->update([
                'image_path' => $this->fileUploadService->store(
                    $request->file('image'),
                    'services/'.$service->id
                ),
            ]);
        }

        return redirect()
            ->route('services.index')
            ->with('status', __('Service updated successfully.'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->fileUploadService->delete($service->image_path);
        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('status', __('Service deleted successfully.'));
    }
}
