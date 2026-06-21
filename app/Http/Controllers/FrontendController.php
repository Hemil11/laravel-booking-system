<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Service;
use App\Models\Staff;
use App\Support\PerformanceCache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        $featuredServices = collect();
        if (Schema::hasTable('services')) {
            $featuredServices = Service::query()
                ->select(['id', 'name', 'duration', 'price', 'image_path'])
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
                ->select(['id', 'name', 'description', 'duration', 'price', 'image_path'])
                ->orderBy('name')
                ->paginate(9);
        }

        return view('frontend.services', [
            'services' => $services,
        ]);
    }

    public function serviceShow(int|string $id): View
    {
        $service = Service::query()->findOrFail((int) $id);

        return view('frontend.service-detail', [
            'service' => $service,
        ]);
    }

    public function book(): View
    {
        $staffMembers = collect();
        $services = collect();

        if (Schema::hasTable('staffs')) {
            $staffMembers = Cache::remember(
                PerformanceCache::BOOKING_FORM_STAFF,
                config('performance.booking_form_ttl'),
                static fn () => Staff::query()
                    ->where('is_active', true)
                    ->orderBy('full_name')
                    ->select(['id', 'full_name'])
                    ->get()
            );
        }

        if (Schema::hasTable('services')) {
            $services = Cache::remember(
                PerformanceCache::BOOKING_FORM_SERVICES,
                config('performance.booking_form_ttl'),
                static fn () => Service::query()
                    ->orderBy('name')
                    ->select(['id', 'name', 'duration'])
                    ->get()
            );
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

    public function about(): View
    {
        return view('frontend.about');
    }

    public function careers(): View
    {
        return view('frontend.careers');
    }

    public function privacy(): View
    {
        return view('frontend.privacy');
    }

    public function terms(): View
    {
        return view('frontend.terms');
    }

    public function refund(): View
    {
        return view('frontend.refund');
    }

    public function dataDeletion(): View
    {
        return view('frontend.data-deletion');
    }

    public function help(): View
    {
        return view('frontend.help');
    }

    public function faq(): View
    {
        return view('frontend.faq');
    }

    public function sitemap(): \Illuminate\Http\Response
    {
        $services = collect();
        if (Schema::hasTable('services')) {
            $services = Service::query()->select(['id', 'updated_at'])->get();
        }

        $staticUrls = [
            route('frontend.home') => '1.0',
            route('frontend.services') => '0.8',
            route('frontend.book') => '0.9',
            route('frontend.contact') => '0.7',
            route('frontend.about') => '0.6',
            route('frontend.careers') => '0.5',
            route('frontend.faq') => '0.7',
            route('frontend.help') => '0.6',
            route('frontend.privacy') => '0.3',
            route('frontend.terms') => '0.3',
            route('frontend.refund') => '0.3',
            route('frontend.data-deletion') => '0.3',
        ];

        return response()->view('frontend.sitemap', [
            'staticUrls' => $staticUrls,
            'services' => $services,
        ])->header('Content-Type', 'text/xml');
    }
}
