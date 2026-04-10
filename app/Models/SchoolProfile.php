<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'npsn',
        'school_status',
        'accreditation',
        'address',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'history_content',
        'established_year',
        'land_area',
        'building_area',
        'total_classes',
        'total_students',
        'total_teachers',
        'total_staff',
        'vision',
        'missions',
        'logo',
        'hero_image',
    ];

    protected $casts = [
        'missions' => 'array',
        'established_year' => 'integer',
        'total_classes' => 'integer',
        'total_students' => 'integer',
        'total_teachers' => 'integer',
        'total_staff' => 'integer',
    ];

    /**
     * Get or create school profile
     */
    public static function getOrCreate(): self
    {
        $defaults = [
            'school_name' => 'SD N 2 Dermolo',
            'npsn' => '20318087',
            'school_status' => 'Negeri',
            'accreditation' => 'B',
            'city' => 'Jepara',
            'province' => 'Jawa Tengah',
        ];

        if (! Schema::hasTable((new static())->getTable())) {
            return new self($defaults);
        }

        return self::firstOrCreate([], $defaults);
    }
}
