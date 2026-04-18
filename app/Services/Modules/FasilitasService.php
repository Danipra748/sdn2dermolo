<?php

namespace App\Services\Modules;

use App\Models\Fasilitas;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use App\Traits\CacheableService;
use Illuminate\Support\Facades\Cache;

class FasilitasService
{
    use CacheableService;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    private const WARNA_TO_HERO = [
        'blue' => 'from-blue-500 to-cyan-600',
        'green' => 'from-emerald-600 to-teal-600',
        'yellow' => 'from-yellow-500 to-amber-600',
        'pink' => 'from-pink-500 to-rose-600',
        'purple' => 'from-purple-600 to-indigo-700',
        'orange' => 'from-orange-500 to-red-500',
    ];

    /**
     * Store a new facility.
     */
    public function store(array $validated, Request $request): Fasilitas
    {
        $this->clearModuleCache(['fasilitas_public_' . ($validated['nama'] ?? '')]);
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->fileService->upload($request, 'foto', 'fasilitas');
        }
        return Fasilitas::create($validated);
    }

    /**
     * Update an existing facility.
     */
    public function update(Fasilitas $fasilitas, array $validated, Request $request): Fasilitas
    {
        $this->clearModuleCache(['fasilitas_public_' . $fasilitas->nama, 'fasilitas_public_' . ($validated['nama'] ?? '')]);
        if ($request->boolean('remove_foto')) {
            $validated = array_merge($validated, $this->fileService->handleModelDeletion($fasilitas, 'foto'));
        }

        if ($request->hasFile('foto')) {
            $validated = array_merge($validated, $this->fileService->handleModelUpload($fasilitas, 'foto', $request, 'foto', 'fasilitas'));
        }

        $fasilitas->update($validated);
        return $fasilitas;
    }

    /**
     * Build public data for a facility with robust key-based caching.
     */
    public function buildPublicData(string $nama): array
    {
        $cacheKey = 'fasilitas_public_' . $nama;

        return Cache::rememberForever($cacheKey, function () use ($nama) {
            $item = Fasilitas::where('nama', $nama)->first();
            $default = $this->getDefaultData($nama);
            $data = $default;
            
            $kontenValue = $item?->konten;
            if (is_array($kontenValue)) {
                $data = array_replace_recursive($data, $kontenValue);
                $data['konten_html'] = null;
            } elseif (is_string($kontenValue) && trim($kontenValue) !== '') {
                $data['konten_html'] = $kontenValue;
            } else {
                $data['konten_html'] = null;
            }

            $warna = $item?->warna ?? 'blue';
            $data['title'] = $item?->nama ?? $nama;
            $data['subtitle'] = ($item && filled($item->deskripsi)) ? $item->deskripsi : ($default['subtitle'] ?? '');
            $data['card_bg_image'] = $item?->card_bg_image;
            $data['hero_color'] = self::WARNA_TO_HERO[$warna] ?? self::WARNA_TO_HERO['blue'];
            
            return $data;
        });
    }

    /**
     * Get default data for static facilities.
     */
    public function getDefaultData(string $nama): array
    {
... (rest of method unchanged)
