<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

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
