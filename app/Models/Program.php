<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadableTrait;

class Program extends Model
{
    use HasFactory, UploadableTrait;

    /**
     * Define uploadable columns for this model.
     * These columns can hold uploaded file paths.
     */
    protected function getUploadableColumns(): array
    {
        return [
            'foto',
            'card_bg_image',
            'logo',
        ];
    }

    protected $fillable = [
        'slug',
        'title',
        'desc',
        'highlight_1',
        'highlight_2',
        'highlight_3',
        'foto',
        'card_bg_image',
        'logo',
        'emoji',
        'hero_color',
    ];

    public function photos()
    {
        return $this->hasMany(ProgramPhoto::class)->orderBy('id');
    }
}
