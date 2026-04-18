<?php

namespace App\Services\Modules;

use App\Models\Prestasi;
use App\Models\SiteSetting;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use App\Traits\CacheableService;

class PrestasiService
{
    use CacheableService;
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store new achievement.
     */
    public function store(array $data, Request $request): Prestasi
    {
        $this->flushCacheTags(['prestasi']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->upload($request, 'foto', 'prestasi');
        }
        return Prestasi::create($data);
    }

    /**
     * Update achievement.
     */
    public function update(Prestasi $prestasi, array $data, Request $request): Prestasi
    {
        $this->flushCacheTags(['prestasi']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->replace($prestasi->foto, $request, 'foto', 'prestasi');
        }
        $prestasi->update($data);
        return $prestasi;
    }

    /**
     * Delete achievement and photo.
     */
    public function delete(Prestasi $prestasi): bool
    {
        $this->flushCacheTags(['prestasi']);
        $this->fileService->delete($prestasi->foto);
        return $prestasi->delete();
    }

    /**
     * Update achievement summary in site settings.
     */
    public function updateSummary(string $text): void
    {
        $this->flushCacheTags(['prestasi', 'site_settings']);
        $lines = collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        SiteSetting::setValue('prestasi_ringkasan', $lines);
    }
}
