<?php

namespace App\Services\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Upload a file to a specific storage path.
     */
    public function upload(Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $file = $request->file($fieldName);
        
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($storagePath, $disk);
    }

    /**
     * Delete old file and upload new one.
     */
    public function replace(?string $oldFilePath, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string
    {
        if ($oldFilePath) {
            $this->delete($oldFilePath, $disk);
        }

        return $this->upload($request, $fieldName, $storagePath, $disk);
    }

    /**
     * Delete a physical file from storage.
     */
    public function delete(?string $filePath, string $disk = 'public'): bool
    {
        if (!$filePath) {
            return false;
        }

        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }
        return false;
    }

    /**
     * Handle file upload for model attributes.
     */
    public function handleModelUpload($model, string $column, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): array
    {
        $data = [];

        if ($request->hasFile($fieldName)) {
            if ($model->{$column}) {
                $this->delete($model->{$column}, $disk);
            }

            $data[$column] = $this->upload($request, $fieldName, $storagePath, $disk);
        }

        return $data;
    }

    /**
     * Handle file deletion for model attributes.
     */
    public function handleModelDeletion($model, string $column, string $disk = 'public'): array
    {
        $data = [];

        if ($model->{$column}) {
            $this->delete($model->{$column}, $disk);
            $data[$column] = null;
        }

        return $data;
    }
}
