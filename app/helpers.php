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

        return Storage::disk(config('media.disk', 'public'))->url($path);
    }
}
