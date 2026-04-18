<?php

namespace App\Services\Modules;

use App\Models\PpdbSetting;
use App\Models\PpdbBanner;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PpdbService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Get current PPDB status based on time.
     */
    public function getStatus(): string
    {
        $settings = PpdbSetting::getInstance();
        $now = Carbon::now('Asia/Jakarta');

        if (!$settings->start_date || !$settings->end_date) {
            return 'closed';
        }

        if ($now->lt($settings->start_date)) {
            return 'waiting';
        }

        if ($now->gt($settings->end_date)) {
            return 'closed';
        }

        if ($now->diffInHours($settings->end_date) <= 24) {
            return 'closing_soon';
        }

        return 'open';
    }

    /**
     * Update PPDB settings.
     */
    public function updateSettings(array $data): PpdbSetting
    {
        $settings = PpdbSetting::getInstance();
        $settings->update($data);
        return $settings;
    }

    /**
     * Store new banner.
     */
    public function storeBanner(Request $request): PpdbBanner
    {
        $data = $request->only(['title', 'order']);
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileService->upload($request, 'image', 'ppdb/banners');
        }
        return PpdbBanner::create($data);
    }

    /**
     * Update existing banner.
     */
    public function updateBanner(Request $request, PpdbBanner $banner): PpdbBanner
    {
        $data = $request->only(['title', 'order']);
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileService->replace($banner->image_path, $request, 'image', 'ppdb/banners');
        }
        $banner->update($data);
        return $banner;
    }

    /**
     * Delete banner.
     */
    public function deleteBanner(PpdbBanner $banner): bool
    {
        $this->fileService->delete($banner->image_path);
        return $banner->delete();
    }
}
