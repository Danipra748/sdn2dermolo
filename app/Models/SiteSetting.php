<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    private const SCHOOL_LOCATION_KEY = 'school_location';

    /**
     * Define uploadable columns for this model.
     * These columns can hold uploaded file paths.
     */
    protected $uploadableColumns = [
        'hero_image',
        'foto_kepsek',
    ];

    protected $fillable = [
        'key',
        'value',
        'hero_image',
        'foto_kepsek',
        'school_latitude',
        'school_longitude',
        'map_zoom',
    ];

    protected $casts = [
        'school_latitude' => 'decimal:8',
        'school_longitude' => 'decimal:8',
        'map_zoom' => 'integer',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return $default;
        }

        $setting = static::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return;
        }

        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : (string) $value]
        );
    }

    /**
     * Get school location coordinates
     */
    public static function getSchoolLocation(): array
    {
        $defaults = [
            'latitude' => -6.8283,
            'longitude' => 110.6536,
            'zoom' => 15,
        ];

        if (! Schema::hasTable((new static)->getTable())) {
            return $defaults;
        }

        $setting = static::where('key', self::SCHOOL_LOCATION_KEY)->first();

        if ($setting?->value) {
            $decoded = json_decode((string) $setting->value, true);

            if (is_array($decoded)) {
                return [
                    'latitude' => (float) ($decoded['latitude'] ?? $defaults['latitude']),
                    'longitude' => (float) ($decoded['longitude'] ?? $defaults['longitude']),
                    'zoom' => (int) ($decoded['zoom'] ?? $defaults['zoom']),
                ];
            }
        }

        $hasCoordinateColumns = collect([
            'school_latitude',
            'school_longitude',
            'map_zoom',
        ])->every(fn (string $column) => Schema::hasColumn('site_settings', $column));

        if ($hasCoordinateColumns) {
            $setting = static::whereNotNull('school_latitude')
                ->orWhereNotNull('school_longitude')
                ->orderBy('id')
                ->first();
        }

        return [
            'latitude' => (float) ($setting?->school_latitude ?? $defaults['latitude']),
            'longitude' => (float) ($setting?->school_longitude ?? $defaults['longitude']),
            'zoom' => (int) ($setting?->map_zoom ?? $defaults['zoom']),
        ];
    }

    /**
     * Update school location coordinates
     */
    public static function updateSchoolLocation(float $latitude, float $longitude, int $zoom = 15): bool
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return false;
        }

        $payload = [
            'latitude' => round($latitude, 8),
            'longitude' => round($longitude, 8),
            'zoom' => $zoom,
        ];

        $hasCoordinateColumns = collect([
            'school_latitude',
            'school_longitude',
            'map_zoom',
        ])->every(fn (string $column) => Schema::hasColumn('site_settings', $column));

        if (! $hasCoordinateColumns) {
            static::setValue(self::SCHOOL_LOCATION_KEY, $payload);

            return true;
        }

        $setting = static::firstOrNew(['key' => self::SCHOOL_LOCATION_KEY]);
        $setting->school_latitude = $payload['latitude'];
        $setting->school_longitude = $payload['longitude'];
        $setting->map_zoom = $payload['zoom'];
        $setting->value = json_encode($payload);

        return $setting->save();
    }

    /**
     * Get hero image path
     */
    public static function getHeroImage(): ?string
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return null;
        }

        $setting = static::where('key', 'hero_image')->first();

        return $setting?->hero_image;
    }

    /**
     * Upload hero image
     */
    public static function uploadHeroImage($image): ?string
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return null;
        }

        // Delete old image if exists
        $oldImage = self::getHeroImage();
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        // Store new image
        $path = $image->store('hero-backgrounds', 'public');

        // Update or create setting
        static::updateOrCreate(
            ['key' => 'hero_image'],
            ['hero_image' => $path]
        );

        return $path;
    }

    /**
     * Delete hero image
     */
    public static function deleteHeroImage(): bool
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return false;
        }

        $oldImage = self::getHeroImage();
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return static::where('key', 'hero_image')->update(['hero_image' => null]);
    }

    /**
     * Get kepala sekolah foto path
     */
    public static function getFotoKepsek(): ?string
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return null;
        }

        $setting = static::where('key', 'foto_kepsek')->first();

        return $setting?->foto_kepsek;
    }

    /**
     * Upload kepala sekolah foto
     */
    public static function uploadFotoKepsek($image): ?string
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return null;
        }

        try {
            // Delete old foto if exists
            $oldFoto = self::getFotoKepsek();
            if ($oldFoto) {
                Storage::disk('public')->delete($oldFoto);
            }

            // Store new foto
            $path = $image->store('kepala-sekolah', 'public');

            // Update or create setting using updateOrCreate for safety
            static::updateOrCreate(
                ['key' => 'foto_kepsek'],
                ['foto_kepsek' => $path]
            );

            return $path;
        } catch (\Exception $e) {
            \Log::error('Upload foto kepsek failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Delete kepala sekolah foto
     */
    public static function deleteFotoKepsek(): bool
    {
        if (! Schema::hasTable((new static)->getTable())) {
            return false;
        }

        try {
            $oldFoto = self::getFotoKepsek();
            if ($oldFoto) {
                Storage::disk('public')->delete($oldFoto);
            }

            // Set to null instead of deleting row - keeps structure intact
            static::updateOrCreate(
                ['key' => 'foto_kepsek'],
                ['foto_kepsek' => null]
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Delete foto kepsek failed: '.$e->getMessage());

            return false;
        }
    }
}
