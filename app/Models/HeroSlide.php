<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get all active slides ordered by display_order
     */
    public static function getActiveOrdered()
    {
        return self::where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }

    /**
     * Get the maximum display_order value
     */
    public static function getMaxOrder(): int
    {
        $max = self::max('display_order');
        return $max !== null ? (int) $max : 0;
    }

    /**
     * Upload slide image
     */
    public function uploadImage($image): string
    {
        // Delete old image if exists
        if ($this->image_path) {
            Storage::disk('public')->delete($this->image_path);
        }

        // Store new image
        $path = $image->store('hero-slides', 'public');
        $this->update(['image_path' => $path]);

        return $path;
    }

    /**
     * Delete the slide and its image
     */
    public function deleteWithImage(): bool
    {
        if ($this->image_path) {
            Storage::disk('public')->delete($this->image_path);
        }

        return $this->delete();
    }

    /**
     * Swap order with another slide
     */
    public function swapOrder(HeroSlide $otherSlide): void
    {
        $tempOrder = $this->display_order;
        $this->update(['display_order' => $otherSlide->display_order]);
        $otherSlide->update(['display_order' => $tempOrder]);
    }

    /**
     * Move slide up in order
     */
    public function moveUp(): void
    {
        $previousSlide = self::where('display_order', '<', $this->display_order)
            ->where('is_active', true)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previousSlide) {
            $this->swapOrder($previousSlide);
        }
    }

    /**
     * Move slide down in order
     */
    public function moveDown(): void
    {
        $nextSlide = self::where('display_order', '>', $this->display_order)
            ->where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($nextSlide) {
            $this->swapOrder($nextSlide);
        }
    }

    /**
     * Reorder slides based on array of IDs
     */
    public static function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            self::where('id', $id)->update(['display_order' => $index]);
        }
    }
}
