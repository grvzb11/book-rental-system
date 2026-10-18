<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class BookCoverService
{
    private const DIRECTORY = 'uploads/books';

    public function replace(?UploadedFile $file, ?string $currentPath = null, bool $removeCurrent = false): ?string
    {
        if ($file) {
            $this->delete($currentPath);

            return $this->store($file);
        }

        if ($removeCurrent) {
            $this->delete($currentPath);

            return null;
        }

        return $currentPath;
    }

    public function delete(?string $path): void
    {
        if (! $path || ! str_starts_with($path, self::DIRECTORY . '/')) {
            return;
        }

        $absolutePath = public_path($path);

        if (is_file($absolutePath)) {
            @unlink($absolutePath);
        }
    }

    private function store(UploadedFile $file): string
    {
        $directory = public_path(self::DIRECTORY);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = Str::uuid() . '.' . $extension;
        $file->move($directory, $filename);

        return self::DIRECTORY . '/' . $filename;
    }
}
