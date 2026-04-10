<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
        'icon_image',
        'foto',
        'card_bg_image',
        'warna',
        'konten',
    ];

    protected function casts(): array
    {
        return [
            'konten' => 'array',
        ];
    }
}
