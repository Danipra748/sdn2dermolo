<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbBanner extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to only include active banners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
