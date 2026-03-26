<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $directory = trim($directory, '/');

        return $file->store($directory, $this->disk);
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
}
