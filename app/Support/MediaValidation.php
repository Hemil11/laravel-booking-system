<?php

namespace App\Support;

use Illuminate\Contracts\Validation\ValidationRule;

class MediaValidation
{
    /**
     * @return list<string|ValidationRule>
     */
    public static function optionalImage(): array
    {
        return [
            'nullable',
            'image',
            'max:'.config('media.max_image_kilobytes'),
            'mimes:'.implode(',', config('media.image_mimes')),
            'mimetypes:'.implode(',', config('media.image_mime_types', [])),
        ];
    }
}
