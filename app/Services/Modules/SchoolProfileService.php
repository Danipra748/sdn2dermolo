<?php

namespace App\Services\Modules;

use App\Models\SchoolProfile;
use App\Services\Core\FileService;
use App\Services\Core\ImageProcessorService;
use Illuminate\Http\Request;
use App\Traits\CacheableService;

class SchoolProfileService
{
    use CacheableService;
    protected $fileService;
    protected $imageProcessor;

    public function __construct(FileService $fileService, ImageProcessorService $imageProcessor)
    {
        $this->fileService = $fileService;
        $this->imageProcessor = $imageProcessor;
    }

    /**
     * Update school profile data.
     */
    public function updateProfile(Request $request): SchoolProfile
    {
        $this->clearModuleCache();
        $profile = SchoolProfile::getOrCreate();
        $validated = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo_raw')) {
            // Delete old logo
            if ($profile->logo) {
                $this->fileService->delete($profile->logo);
            }

            $cropData = [
                'x' => $request->input('crop_x'),
                'y' => $request->input('crop_y'),
                'w' => $request->input('crop_w'),
                'h' => $request->input('crop_h'),
            ];

            $result = $this->imageProcessor->processAndSave($request->file('logo_raw'), $cropData, 'school-profile', 512, 'logo');
            
            if ($result) {
                $validated['logo'] = $result['path'];
                // Generate Favicon
                $this->imageProcessor->generateFavicon($result['resource'], 'school-profile');
                // Clean up resource
                imagedestroy($result['resource']);
            }
        }

        // Handle missions
        if ($request->has('mission_items')) {
            $missions = array_filter($request->input('mission_items'), function($item) {
                return !empty(trim($item));
            });
            $validated['missions'] = array_values($missions);
        }

        $profile->update($validated);
        return $profile;
    }

    /**
     * Delete school logo.
     */
    public function deleteLogo(): bool
    {
        $this->clearModuleCache();
        $profile = SchoolProfile::getOrCreate();
        if ($profile->logo) {
            $this->fileService->delete($profile->logo);
            return $profile->update(['logo' => null]);
        }
        return false;
    }
}
