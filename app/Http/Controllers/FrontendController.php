<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        $featuredServices = collect();
        if (Schema::hasTable('services')) {
            $featuredServices = Service::query()
                ->orderBy('name')
                ->limit(6)
                ->get();
        }

        return view('frontend.home', [
            'featuredServices' => $featuredServices,
        ]);
    }

    public function services(): View
    {
        /** @var LengthAwarePaginator<int, Service>|Collection<int, Service> $services */
        $services = new LengthAwarePaginator([], 0, 9, 1, [
            'path' => route('frontend.services'),
        ]);

        if (Schema::hasTable('services')) {
            $services = Service::query()
                ->orderBy('name')
                ->paginate(9);
        }

        return view('frontend.services', [
            'services' => $services,
        ]);
    }

    public function book(): View
    {
        $staffMembers = collect();
        $services = collect();

        if (Schema::hasTable('staffs')) {
            $staffMembers = Staff::query()
                ->where('is_active', true)
                ->orderBy('full_name')
                ->get();
        }

        if (Schema::hasTable('services')) {
            $services = Service::query()
                ->orderBy('name')
                ->get();
        }

        return view('frontend.book', [
            'staffMembers' => $staffMembers,
            'services' => $services,
        ]);
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function submitContact(StoreContactRequest $request): RedirectResponse
    {
        return redirect()
            ->route('frontend.contact')
            ->with('status', __('Thanks, :name. We received your message and will get back to you soon.', [
                'name' => $request->validated('name'),
            ]));
    }
}
