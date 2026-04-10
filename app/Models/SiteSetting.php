<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    use HasFactory;

    private const SCHOOL_LOCATION_KEY = 'school_location';

    protected $fillable = [
        'key',
        'value',
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
        if (! Schema::hasTable((new static())->getTable())) {
            return $default;
        }

        $setting = static::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        if (! Schema::hasTable((new static())->getTable())) {
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

        if (! Schema::hasTable((new static())->getTable())) {
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
        if (! Schema::hasTable((new static())->getTable())) {
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
}
