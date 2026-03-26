<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default filesystem disk for user uploads
    |--------------------------------------------------------------------------
    */
    'disk' => env('MEDIA_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Max upload size (kilobytes) for images
    |--------------------------------------------------------------------------
    */
    'max_image_kilobytes' => (int) env('MEDIA_MAX_IMAGE_KB', 5120),

    /*
    |--------------------------------------------------------------------------
    | Allowed image extensions for validation (mimes rule)
    |--------------------------------------------------------------------------
    |
    | @var list<string>
    */
    'image_mimes' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],

    /*
    |--------------------------------------------------------------------------
    | Allowed image MIME types (server-side content type verification)
    |--------------------------------------------------------------------------
    |
    | @var list<string>
    */
    'image_mime_types' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],

];
