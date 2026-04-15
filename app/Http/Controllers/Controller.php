<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    /**
     * Upload a file to a specific storage path.
     * 
     * @param Request $request
     * @param string $fieldName Form field name
     * @param string $storagePath Storage path (e.g., 'program', 'gallery')
     * @param string $disk Storage disk
     * @return string|null File path or null
     */
    protected function uploadFile(Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $file = $request->file($fieldName);
        
        // Validate file
        if (!$file->isValid()) {
            return null;
        }

        return $file->store($storagePath, $disk);
    }

    /**
     * Delete old file and upload new one.
     * 
     * @param string|null $oldFilePath Old file path to delete
     * @param Request $request
     * @param string $fieldName Form field name
     * @param string $storagePath Storage path
     * @param string $disk Storage disk
     * @return string|null New file path or null
     */
    protected function replaceFile(?string $oldFilePath, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string
    {
        // Delete old file if exists
        if ($oldFilePath) {
            $this->deletePhysicalFile($oldFilePath, $disk);
        }

        // Upload new file
        return $this->uploadFile($request, $fieldName, $storagePath, $disk);
    }

    /**
     * Delete a physical file from storage.
     * 
     * @param string $filePath File path
     * @param string $disk Storage disk
     * @return bool
     */
    protected function deletePhysicalFile(string $filePath, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }
        return false;
    }

    /**
     * Handle file upload with old file deletion.
     * This is a convenience method for controller actions.
     * 
     * @param mixed $model Model instance
     * @param string $column Column name
     * @param Request $request
     * @param string $fieldName Form field name
     * @param string $storagePath Storage path
     * @param string $disk Storage disk
     * @return array Data array with column => path
     */
    protected function handleFileUpload($model, string $column, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): array
    {
        $data = [];

        if ($request->hasFile($fieldName)) {
            // Delete old file
            if ($model->{$column}) {
                $this->deletePhysicalFile($model->{$column}, $disk);
            }

            // Upload new file
            $data[$column] = $this->uploadFile($request, $fieldName, $storagePath, $disk);
        }

        return $data;
    }

    /**
     * Handle file deletion (set column to null, don't delete row).
     * 
     * @param mixed $model Model instance
     * @param string $column Column name
     * @param string $disk Storage disk
     * @return array Data array with column => null
     */
    protected function handleFileDeletion($model, string $column, string $disk = 'public'): array
    {
        $data = [];

        if ($model->{$column}) {
            // Delete physical file
            $this->deletePhysicalFile($model->{$column}, $disk);
            
            // Set column to null (DON'T delete row)
            $data[$column] = null;
        }

        return $data;
    }
}
