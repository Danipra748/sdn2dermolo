<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomepageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'section_name',
        'is_active',
        'display_order',
        'title',
        'subtitle',
        'description',
        'background_image',
        'background_overlay_opacity',
        'extra_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'extra_data' => 'array',
        'background_overlay_opacity' => 'decimal:2',
    ];

    /**
     * Get section by key
     */
    public static function getByKey(string $key): ?self
    {
        return self::where('section_key', $key)->first();
    }

    /**
     * Get hero section only
     */
    public static function getHero(): ?self
    {
        return self::where('section_key', 'hero')->first();
    }

    /**
     * Get all active sections ordered
     */
    public static function getActiveOrdered()
    {
        return self::where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }

    /**
     * Get all sections ordered
     */
    public static function getAllOrdered()
    {
        return self::orderBy('display_order')->get();
    }

    /**
     * Upload background image
     */
    public function uploadBackground($image)
    {
        // Delete old image
        if ($this->background_image) {
            Storage::disk('public')->delete($this->background_image);
        }

        // Store new image
        $path = $image->store('homepage-backgrounds', 'public');
        $this->update(['background_image' => $path]);

        return $path;
    }

    /**
     * Delete background image
     */
    public function deleteBackground()
    {
        if ($this->background_image) {
            Storage::disk('public')->delete($this->background_image);
            $this->update(['background_image' => null]);
        }
    }

    /**
     * Get extra data attribute
     */
    public function getExtraDataAttribute($value)
    {
        return json_decode($value ?? '[]', true);
    }

    /**
     * Set extra data attribute
     */
    public function setExtraDataAttribute($value)
    {
        $this->attributes['extra_data'] = is_array($value) ? json_encode($value) : $value;
    }
}
