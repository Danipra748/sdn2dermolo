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
        'warna',
        'konten',
    ];

    protected $casts = [
        'konten' => 'array',
    ];
}
