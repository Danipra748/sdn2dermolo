<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'photo',
        'caption',
        'position',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
