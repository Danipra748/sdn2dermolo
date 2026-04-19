<?php

namespace App\Services\Core;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageProcessorService
{
    /**
     * Process image: crop, resize and convert.
     */
    public function processAndSave(UploadedFile $file, array $cropData, string $directory, int|array $targetSize = 512, string $filenamePrefix = 'img'): ?array
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $path = $file->getRealPath();

            $src = $this->createImageFromPath($path, $extension);
            if (! $src) {
                return null;
            }

            // Determine target width and height
            $tw = is_array($targetSize) ? ($targetSize['w'] ?? 512) : $targetSize;
            $th = is_array($targetSize) ? ($targetSize['h'] ?? 512) : $targetSize;

            // Perform crop
            $cropped = imagecreatetruecolor($cropData['w'], $cropData['h']);
            $this->handleTransparency($cropped);

            imagecopyresampled(
                $cropped, $src,
                0, 0,
                $cropData['x'], $cropData['y'],
                $cropData['w'], $cropData['h'],
                $cropData['w'], $cropData['h']
            );

            // Resize to target size
            $finalImage = imagecreatetruecolor($tw, $th);
            $this->handleTransparency($finalImage);
            imagecopyresampled(
                $finalImage, $cropped,
                0, 0, 0, 0,
                $tw, $th,
                $cropData['w'], $cropData['h']
            );

            // Ensure directory exists
            if (! Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Save as WebP
            $filename = $filenamePrefix.'_'.time().'.webp';
            $fullPath = storage_path('app/public/'.$directory.'/'.$filename);
            imagewebp($finalImage, $fullPath, 90);

            // Clean up resources that won't be used
            imagedestroy($src);
            imagedestroy($cropped);

            return [
                'path' => $directory.'/'.$filename,
                'resource' => $finalImage, // Keep for further processing like favicon
            ];

        } catch (\Exception $e) {
            \Log::error('Image processing error: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Create image resource from path.
     */
    private function createImageFromPath(string $path, string $extension)
    {
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($path);
            case 'png':
                return imagecreatefrompng($path);
            case 'webp':
                return imagecreatefromwebp($path);
            default:
                return null;
        }
    }

    /**
     * Handle transparency for PNG/WebP.
     */
    private function handleTransparency($image)
    {
        imagealphablending($image, false);
        imagesavealpha($image, true);
        $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $transparent);
    }

    /**
     * Generate Favicon from resource.
     */
    public function generateFavicon($imageResource, string $directory): ?string
    {
        $favSize = 48;
        $favicon = imagecreatetruecolor($favSize, $favSize);
        $this->handleTransparency($favicon);

        imagecopyresampled(
            $favicon, $imageResource,
            0, 0, 0, 0,
            $favSize, $favSize,
            imagesx($imageResource), imagesy($imageResource)
        );

        $favFilename = 'favicon_'.time().'.png';
        $favPath = storage_path('app/public/'.$directory.'/'.$favFilename);
        imagepng($favicon, $favPath);

        // Fixed location for dynamic favicon
        $fixedFavPath = storage_path('app/public/school-profile/favicon-dynamic.png');
        copy($favPath, $fixedFavPath);

        imagedestroy($favicon);

        return $directory.'/'.$favFilename;
    }
}
