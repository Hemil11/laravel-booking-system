<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FileUploadService
{
    public function __construct(
        protected ?string $disk = null
    ) {
        $this->disk ??= config('media.disk', 'public');
    }

    /**
     * Store an uploaded file under the given directory (relative to disk root).
     * Returns the stored path (e.g. "services/1/abc.jpg") for persistence in the database.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $this->assertAllowedImage($file);

        $directory = str_replace('..', '', trim($directory, '/'));
        $extension = $file->guessExtension() ?: $file->extension() ?: 'bin';
        $filename = Str::uuid()->toString().'.'.$extension;

        return $file->storeAs($directory, $filename, $this->disk);
    }

    /**
     * Delete a file from the disk if it exists.
     */
    public function delete(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        if (Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->delete($path);
        }
    }

    public function disk(): string
    {
        return $this->disk;
    }

    protected function assertAllowedImage(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw ValidationException::withMessages(['file' => 'Invalid uploaded file.']);
        }

        $allowedMimeTypes = config('media.image_mime_types', []);
        $uploadedMimeType = $file->getMimeType() ?: '';
        if ($allowedMimeTypes !== [] && ! in_array($uploadedMimeType, $allowedMimeTypes, true)) {
            throw ValidationException::withMessages(['file' => 'Unsupported file type.']);
        }
    }
}
