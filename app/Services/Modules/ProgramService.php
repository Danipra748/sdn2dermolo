<?php

namespace App\Services\Modules;

use App\Models\Program;
use App\Models\ProgramPhoto;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use App\Traits\CacheableService;

class ProgramService
{
    use CacheableService;
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store a new program.
     */
    public function store(array $validated, Request $request): Program
    {
        $this->flushCacheTags(['programs']);
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->fileService->upload($request, 'foto', 'program');
        }
        if ($request->hasFile('card_bg_image')) {
            $validated['card_bg_image'] = $this->fileService->upload($request, 'card_bg_image', 'program/card');
        }
        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->fileService->upload($request, 'logo', 'program/logo');
        }

        return Program::create($validated);
    }

    /**
     * Update an existing program.
     */
    public function update(Program $program, array $validated, Request $request): Program
    {
        $this->flushCacheTags(['programs']);
        // Handle file replacements
        $validated = array_merge($validated, $this->fileService->handleModelUpload($program, 'foto', $request, 'foto', 'program'));
        $validated = array_merge($validated, $this->fileService->handleModelUpload($program, 'card_bg_image', $request, 'card_bg_image', 'program/card'));
        $validated = array_merge($validated, $this->fileService->handleModelUpload($program, 'logo', $request, 'logo', 'program/logo'));

        // Handle deletions
        if ($request->boolean('remove_foto')) {
            $validated = array_merge($validated, $this->fileService->handleModelDeletion($program, 'foto'));
        }
        if ($request->boolean('remove_card_bg_image')) {
            $validated = array_merge($validated, $this->fileService->handleModelDeletion($program, 'card_bg_image'));
        }
        if ($request->boolean('remove_logo')) {
            $validated = array_merge($validated, $this->fileService->handleModelDeletion($program, 'logo'));
        }

        $program->update($validated);
        return $program;
    }

    /**
     * Delete a program and its files.
     */
    public function delete(Program $program): bool
    {
        $this->flushCacheTags(['programs']);
        $this->fileService->delete($program->foto);
        $this->fileService->delete($program->card_bg_image);
        $this->fileService->delete($program->logo);
        return $program->delete();
    }

    /**
     * Store program photo.
     */
    public function storePhoto(Program $program, array $data, Request $request): ProgramPhoto
    {
        $this->flushCacheTags(['programs']);
        $data['program_id'] = $program->id;
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->fileService->upload($request, 'photo', 'program/photos');
        }
        return ProgramPhoto::create($data);
    }

    /**
     * Update program photo.
     */
    public function updatePhoto(ProgramPhoto $photo, array $data, Request $request): ProgramPhoto
    {
        $this->flushCacheTags(['programs']);
        if ($request->boolean('remove_photo')) {
            $data = array_merge($data, $this->fileService->handleModelDeletion($photo, 'photo'));
        }
        if ($request->hasFile('photo')) {
            $data = array_merge($data, $this->fileService->handleModelUpload($photo, 'photo', $request, 'photo', 'program/photos'));
        }
        $photo->update($data);
        return $photo;
    }

    /**
     * Delete program photo.
     */
    public function deletePhoto(ProgramPhoto $photo): bool
    {
        $this->flushCacheTags(['programs']);
        $this->fileService->delete($photo->photo);
        return $photo->delete();
    }
}
