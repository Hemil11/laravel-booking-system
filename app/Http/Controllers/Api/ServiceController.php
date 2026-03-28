<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Service;
use App\Support\PerformanceCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Cache::remember(
            PerformanceCache::API_SERVICES_INDEX,
            config('performance.api_services_ttl'),
            static function () {
                return Service::query()
                    ->select(['id', 'name', 'duration', 'price'])
                    ->orderBy('name')
                    ->get()
                    ->map(static fn (Service $service) => [
                        'id' => $service->id,
                        'name' => $service->name,
                        'duration' => $service->duration,
                        'price' => $service->price,
                    ])
                    ->values()
                    ->all();
            }
        );

        return ApiResponse::success(['services' => $services]);
    }
}
