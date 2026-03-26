<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\Media\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {
        $this->middleware(['auth', 'permission:manage_services'])->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(): View
    {
        $services = Service::query()
            ->latest()
            ->paginate(15);

        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        return view('services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = Service::query()->create($request->safe()->only(['name', 'duration', 'price']));

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

    public function show(Service $service): View
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->safe()->only(['name', 'duration', 'price']));

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
            ->route('services.show', $service)
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
