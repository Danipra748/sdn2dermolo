<?php

namespace App\Services\Modules;

use App\Models\SiteSetting;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use App\Traits\CacheableService;

class SiteSettingService
{
    use CacheableService;
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Update principal's greeting.
     */
    public function updateSambutan(array $data, Request $request): void
    {
        $this->flushCacheTags(['site_settings']);
        $existingFoto = SiteSetting::getValue('kepsek_sambutan_foto');

        // Handle deletion
        if ($request->boolean('remove_foto') && $existingFoto) {
            $this->fileService->delete($existingFoto);
            SiteSetting::setValue('kepsek_sambutan_foto', null);
            $existingFoto = null;
        }

        // Handle upload
        if ($request->hasFile('foto')) {
            $path = $this->fileService->replace($existingFoto, $request, 'foto', 'sambutan');
            SiteSetting::setValue('kepsek_sambutan_foto', $path);
        }

        SiteSetting::setValue('kepsek_sambutan_text', $data['sambutan'] ?? '');
    }

    /**
     * Upload principal's official photo.
     */
    public function uploadFotoKepsek(Request $request): ?string
    {
        $this->flushCacheTags(['site_settings']);
        if ($request->hasFile('foto_kepsek')) {
            $existing = SiteSetting::getValue('foto_kepsek');
            $path = $this->fileService->replace($existing, $request, 'foto_kepsek', 'site');
            SiteSetting::setValue('foto_kepsek', $path);
            return $path;
        }
        return null;
    }

    /**
     * Delete principal's official photo.
     */
    public function deleteFotoKepsek(): bool
    {
        $this->flushCacheTags(['site_settings']);
        $existing = SiteSetting::getValue('foto_kepsek');
        if ($existing) {
            $this->fileService->delete($existing);
            SiteSetting::setValue('foto_kepsek', null);
            return true;
        }
        return false;
    }
}
