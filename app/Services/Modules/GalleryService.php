use App\Models\Gallery;
use App\Services\Core\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GalleryService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store new gallery photo.
     */
    public function store(array $data, Request $request): Gallery
    {
        Cache::tags(['galleries'])->flush();
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->upload($request, 'foto', 'gallery');
        }
        return Gallery::create($data);
    }

    /**
     * Update gallery photo.
     */
    public function update(Gallery $gallery, array $data, Request $request): Gallery
    {
        Cache::tags(['galleries'])->flush();
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->fileService->replace($gallery->foto, $request, 'foto', 'gallery');
        }
        $gallery->update($data);
        return $gallery;
    }

    /**
     * Delete gallery photo.
     */
    public function delete(Gallery $gallery): bool
    {
        Cache::tags(['galleries'])->flush();
        $this->fileService->delete($gallery->foto);
        return $gallery->delete();
    }
}
