<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait StoresImages
{
    protected function imageValidationRule(): string
    {
        return 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096';
    }

    protected function storeImage(Request $request, string $field, string $directory, ?string $current = null, bool $keepExisting = false): ?string
    {
        if ($request->hasFile($field)) {
            $this->deleteStoredImage($current);

            /** @var UploadedFile $file */
            $file = $request->file($field);
            $path = $file->store($directory, 'public');

            return 'storage/'.$path;
        }

        return $keepExisting ? $current : null;
    }

    protected function deleteStoredImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            $relative = str_replace('storage/', '', $path);
            if (Storage::disk('public')->exists($relative)) {
                Storage::disk('public')->delete($relative);
            }
        }
    }
}
