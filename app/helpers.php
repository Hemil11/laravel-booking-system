<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * Public URL for a path stored on the configured media disk, or null if empty.
     */
    function media_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        // Static catalog images live under public/services-images (see ServiceSeeder).
        if (str_starts_with($path, 'services-images/')) {
            return asset($path);
        }

        return Storage::disk(config('media.disk', 'public'))->url($path);
    }
}

if (! function_exists('service_image_url')) {
    /**
     * Public URL for a service image: static files under public/services-images or uploaded media disk paths.
     */
    function service_image_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'services-images/')) {
            return asset($path);
        }

        return media_url($path);
    }
}
