<?php

namespace App\Services\Modules;

use App\Models\Guru;
use App\Services\Core\FileService;
use App\Traits\CacheableService;
use Illuminate\Http\Request;

class GuruService
{
    use CacheableService;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store new teacher.
     */
    public function store(array $data, Request $request): Guru
    {
        $this->clearModuleCache();
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->fileService->upload($request, 'photo', 'guru');
        }

        return Guru::create($data);
    }

    /**
     * Update teacher.
     */
    public function update(Guru $guru, array $data, Request $request): Guru
    {
        $this->clearModuleCache();
        if ($request->boolean('remove_photo')) {
            $data = array_merge($data, $this->fileService->handleModelDeletion($guru, 'photo'));
        }

        if ($request->hasFile('photo')) {
            $data = array_merge($data, $this->fileService->handleModelUpload($guru, 'photo', $request, 'photo', 'guru'));
        }

        $guru->update($data);

        return $guru;
    }

    /**
     * Delete teacher and photo.
     */
    public function delete(Guru $guru): bool
    {
        $this->clearModuleCache();
        $this->fileService->delete($guru->photo);

        return $guru->delete();
    }
}
