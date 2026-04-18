<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Services\Modules\HeroSlideService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminHeroSlideController extends Controller
{
    protected $heroSlideService;

    public function __construct(HeroSlideService $heroSlideService)
    {
        $this->heroSlideService = $heroSlideService;
    }

    /**
     * Display hero slides management page
     */
    public function index()
    {
        $slides = HeroSlide::orderBy('display_order')->get();

        return view('admin.hero-slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-slides.form', [
            'slide' => new HeroSlide,
        ]);
    }

    /**
     * Store a new hero slide
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_w' => 'nullable|numeric',
            'crop_h' => 'nullable|numeric',
        ]);

        try {
            $this->heroSlideService->store($validated, $request);

            return redirect()->route('admin.hero-slides.index')->with('success', 'Slide baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Hero slide upload failed: '.$e->getMessage());

            return back()->with('error', 'Gagal mengunggah slide.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.form', [
            'slide' => $heroSlide,
        ]);
    }

    /**
     * Update hero slide
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_w' => 'nullable|numeric',
            'crop_h' => 'nullable|numeric',
        ]);

        try {
            $this->heroSlideService->update($heroSlide, $validated, $request);

            return redirect()->route('admin.hero-slides.index')->with('success', 'Slide berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Hero slide update failed: '.$e->getMessage());

            return back()->with('error', 'Gagal memperbarui slide.');
        }
    }

    /**
     * Delete hero slide
     */
    public function destroy(HeroSlide $heroSlide)
    {
        $this->heroSlideService->delete($heroSlide);

        return back()->with('success', 'Slide berhasil dihapus.');
    }

    /**
     * Update slide order via drag and drop
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'ordered_ids' => 'required|array',
            'ordered_ids.*' => 'exists:hero_slides,id',
        ]);

        HeroSlide::reorder($validated['ordered_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Urutan slide berhasil diperbarui.',
        ]);
    }

    /**
     * Move slide up
     */
    public function moveUp(HeroSlide $heroSlide)
    {
        $heroSlide->moveUp();

        return back()->with('success', 'Slide dipindahkan ke atas.');
    }

    /**
     * Move slide down
     */
    public function moveDown(HeroSlide $heroSlide)
    {
        $heroSlide->moveDown();

        return back()->with('success', 'Slide dipindahkan ke bawah.');
    }

    /**
     * Toggle slide active status
     */
    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => ! $heroSlide->is_active]);

        return back()->with('success', 'Status slide berhasil diubah.');
    }
}
