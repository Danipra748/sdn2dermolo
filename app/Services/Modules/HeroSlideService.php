<?php

namespace App\Services\Modules;

use App\Models\HeroSlide;
use App\Services\Core\FileService;
use App\Services\Core\ImageProcessorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HeroSlideService
{
    protected $fileService;
    protected $imageProcessor;

    public function __construct(FileService $fileService, ImageProcessorService $imageProcessor)
    {
        $this->fileService = $fileService;
        $this->imageProcessor = $imageProcessor;
    }

    /**
     * Store new hero slide.
     */
    public function store(array $data, Request $request): HeroSlide
    {
        Cache::tags(['hero_slides'])->flush();
        $data['display_order'] = HeroSlide::getMaxOrder() + 1;
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            if ($request->filled(['crop_x', 'crop_y', 'crop_w', 'crop_h'])) {
                $cropData = [
                    'x' => $request->input('crop_x'),
                    'y' => $request->input('crop_y'),
                    'w' => $request->input('crop_w'),
                    'h' => $request->input('crop_h'),
                ];
                
                $result = $this->imageProcessor->processAndSave(
                    $request->file('image'),
                    $cropData,
                    'hero-slides',
                    ['w' => 1920, 'h' => 1080],
                    'hero'
                );

                if ($result) {
                    $data['image_path'] = $result['path'];
                    imagedestroy($result['resource']);
                }
            } else {
                $data['image_path'] = $this->fileService->upload($request, 'image', 'hero-slides');
            }
        }

        return HeroSlide::create($data);
    }

    /**
     * Update hero slide.
     */
    public function update(HeroSlide $slide, array $data, Request $request): HeroSlide
    {
        Cache::tags(['hero_slides'])->flush();
        if ($request->hasFile('image')) {
            // Delete old image
            $this->fileService->delete($slide->image_path);

            if ($request->filled(['crop_x', 'crop_y', 'crop_w', 'crop_h'])) {
                $cropData = [
                    'x' => $request->input('crop_x'),
                    'y' => $request->input('crop_y'),
                    'w' => $request->input('crop_w'),
                    'h' => $request->input('crop_h'),
                ];
                
                $result = $this->imageProcessor->processAndSave(
                    $request->file('image'),
                    $cropData,
                    'hero-slides',
                    ['w' => 1920, 'h' => 1080],
                    'hero'
                );

                if ($result) {
                    $data['image_path'] = $result['path'];
                    imagedestroy($result['resource']);
                }
            } else {
                $data['image_path'] = $this->fileService->upload($request, 'image', 'hero-slides');
            }
        }

        $slide->update($data);
        return $slide;
    }

    /**
     * Delete hero slide and image.
     */
    public function delete(HeroSlide $slide): bool
    {
        Cache::tags(['hero_slides'])->flush();
        $this->fileService->delete($slide->image_path);
        return $slide->delete();
    }
}
