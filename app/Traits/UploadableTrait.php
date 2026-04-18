<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UploadableTrait
 *
 * Provides reusable upload/delete methods that use updateOrCreate pattern.
 * This ensures database rows are never deleted, only column values are updated.
 *
 * Usage in Model:
 * - Use UploadableTrait;
 * - Override getUploadableColumns() method to define column names that can hold files
 *
 * Example:
 * class Program extends Model
 * {
 *     use UploadableTrait;
 *
 *     protected function getUploadableColumns(): array
 *     {
 *         return ['foto', 'card_bg_image', 'logo'];
 *     }
 * }
 */
trait UploadableTrait
{
    /**
     * Get the uploadable columns for this model.
     * Models should override this method to define their uploadable columns.
     */
    protected function getUploadableColumns(): array
    {
        // Default empty array - override in your model
        return property_exists($this, 'uploadableColumns') ? $this->uploadableColumns : [];
    }

    /**
     * Upload file to a specific column using updateOrCreate pattern.
     *
     * @param  int|string  $id  Model ID
     * @param  string  $column  Column name to upload to
     * @param  UploadedFile  $file  Uploaded file
     * @param  string  $path  Storage path
     * @param  string  $disk  Storage disk
     * @return string|null File path or null on failure
     */
    public static function uploadToColumn($id, string $column, $file, string $path, string $disk = 'public'): ?string
    {
        $model = static::find($id);
        if (! $model) {
            return null;
        }

        // Validate column is uploadable
        if (! in_array($column, $model->getUploadableColumns())) {
            throw new \InvalidArgumentException("Column {$column} is not uploadable");
        }

        try {
            // Delete old file if exists
            $oldFile = $model->{$column};
            if ($oldFile) {
                Storage::disk($disk)->delete($oldFile);
            }

            // Store new file
            $newPath = $file->store($path, $disk);

            // Update using updateOrCreate pattern
            static::where('id', $id)->update([$column => $newPath]);

            return $newPath;
        } catch (\Exception $e) {
            \Log::error("Upload to column {$column} failed: ".$e->getMessage());

            return null;
        }
    }

    /**
     * Delete file from a specific column (set to null, don't delete row).
     *
     * @param  int|string  $id  Model ID
     * @param  string  $column  Column name to delete from
     * @param  string  $disk  Storage disk
     */
    public static function deleteFromColumn($id, string $column, string $disk = 'public'): bool
    {
        $model = static::find($id);
        if (! $model) {
            return false;
        }

        // Validate column is uploadable
        if (! in_array($column, $model->getUploadableColumns())) {
            throw new \InvalidArgumentException("Column {$column} is not uploadable");
        }

        try {
            // Delete physical file
            $oldFile = $model->{$column};
            if ($oldFile) {
                Storage::disk($disk)->delete($oldFile);
            }

            // Set column to null (DON'T delete row)
            static::where('id', $id)->update([$column => null]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Delete from column {$column} failed: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Helper method to check if column has a file.
     *
     * @param  int|string  $id  Model ID
     * @param  string  $column  Column name
     */
    public static function hasFileInColumn($id, string $column): bool
    {
        $model = static::find($id);
        if (! $model) {
            return false;
        }

        return ! empty($model->{$column});
    }

    /**
     * Helper method to get file path from column.
     *
     * @param  int|string  $id  Model ID
     * @param  string  $column  Column name
     */
    public static function getFileFromColumn($id, string $column): ?string
    {
        $model = static::find($id);
        if (! $model) {
            return null;
        }

        return $model->{$column};
    }
}
