<?php

namespace App\Services\Modules;

use App\Models\SiteSetting;
use App\Services\Core\FileService;
use App\Services\Core\ImageProcessorService;
use App\Traits\CacheableService;
use Illuminate\Http\Request;

class SiteSettingService
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
     * Update principal's greeting and photo with cropping.
     */
    public function updateSambutanAndFoto(array $data, Request $request): void
    {
        $this->clearModuleCache();

        $sambutanFotoKey = 'kepsek_sambutan_foto';
        $fotoKepsekKey = 'foto_kepsek';

        // Handle deletion
        if ($request->boolean('remove_foto')) {
            $this->fileService->delete(SiteSetting::getValue($sambutanFotoKey));
            $this->fileService->delete(SiteSetting::getValue($fotoKepsekKey));
            SiteSetting::setValue($sambutanFotoKey, null);
            SiteSetting::setValue($fotoKepsekKey, null);
        }

        // Handle upload
        if ($request->hasFile('foto')) {
            // Delete old photos first
            $this->fileService->delete(SiteSetting::getValue($sambutanFotoKey));
            $this->fileService->delete(SiteSetting::getValue($fotoKepsekKey));

            $path = null;
            if ($request->filled(['crop_x', 'crop_y', 'crop_w', 'crop_h'])) {
                $cropData = [
                    'x' => $request->input('crop_x'),
                    'y' => $request->input('crop_y'),
                    'w' => $request->input('crop_w'),
                    'h' => $request->input('crop_h'),
                ];

                $result = $this->imageProcessor->processAndSave(
                    $request->file('foto'),
                    $cropData,
                    'site',
                    ['w' => 800, 'h' => 1000], // Target 4:5 ratio
                    'foto-kepsek'
                );

                if ($result) {
                    $path = $result['path'];
                    imagedestroy($result['resource']);
                }
            } else {
                // Fallback for non-cropped upload
                $path = $this->fileService->upload($request, 'foto', 'site');
            }

            if ($path) {
                // Set both keys to the same image
                SiteSetting::setValue($sambutanFotoKey, $path);
                SiteSetting::setValue($fotoKepsekKey, $path);
            }
        }

        SiteSetting::setValue('kepsek_sambutan_text', $data['sambutan'] ?? '');
    }
}
