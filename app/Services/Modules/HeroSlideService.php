<?php

namespace App\Services\Modules;

use App\Models\HeroSlide;
use App\Services\Core\FileService;
use Illuminate\Http\Request;

class HeroSlideService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store new hero slide.
     */
    public function store(array $data, Request $request): HeroSlide
    {
        $data['display_order'] = HeroSlide::getMaxOrder() + 1;
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileService->upload($request, 'image', 'hero-slides');
        }

        return HeroSlide::create($data);
    }

    /**
     * Update hero slide.
     */
    public function update(HeroSlide $slide, array $data, Request $request): HeroSlide
    {
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileService->replace($slide->image_path, $request, 'image', 'hero-slides');
        }

        $slide->update($data);
        return $slide;
    }

    /**
     * Delete hero slide and image.
     */
    public function delete(HeroSlide $slide): bool
    {
        $this->fileService->delete($slide->image_path);
        return $slide->delete();
    }
}
