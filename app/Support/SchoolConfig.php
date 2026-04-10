<?php

namespace App\Support;

/**
 * Static School Configuration Helper
 * 
 * Provides clean access to hardcoded school configuration data
 * that was previously stored in the database.
 */
class SchoolConfig
{
    /**
     * Get contact information
     */
    public static function contact(): array
    {
        return config('school.contact', [
            'address' => "Desa Dermolo, Kecamatan Kembang\nKabupaten Jepara, Provinsi Jawa Tengah",
            'phone' => '0896-6898-2633',
            'email' => 'sdndermolo728@gmail.com',
            'maps_url' => '',
            'latitude' => -6.8283,
            'longitude' => 110.6536,
            'zoom' => 15,
            'operating_hours' => [
                'weekdays' => 'Senin - Jumat: 07.00 - 14.00 WIB',
                'saturday' => 'Sabtu: 07.00 - 13.00 WIB',
            ],
        ]);
    }

    /**
     * Get homepage hero configuration
     */
    public static function hero(): array
    {
        return config('school.homepage.hero', [
            'is_active' => true,
            'title' => 'Sekolah yang',
            'subtitle' => 'Membentuk',
            'description' => null,
            'badge_text' => 'SELAMAT DATANG DI SD N 2 DERMolo',
            'background_overlay_opacity' => 0.35,
            'background_image' => null,
            'slideshow_images' => [],
            'slide_texts' => [],
        ]);
    }

    /**
     * Get school profile information
     */
    public static function school(): array
    {
        return config('school.school', [
            'name' => 'SD N 2 Dermolo',
            'full_name' => 'Sekolah Dasar Negeri 2 Dermolo',
            'address_full' => 'Desa Dermolo RT. 03 RW. 01, Kecamatan Kembang, Kabupaten Jepara, Provinsi Jawa Tengah',
            'district' => 'Kembang',
            'regency' => 'Jepara',
            'province' => 'Jawa Tengah',
            'whatsapp' => '6289668982633',
        ]);
    }

    /**
     * Get address lines (split by newline)
     */
    public static function addressLines(): \Illuminate\Support\Collection
    {
        $contact = self::contact();
        return collect(explode("\n", $contact['address'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values();
    }

    /**
     * Get Google Maps embed URL
     */
    public static function mapsEmbed(): string
    {
        $contact = self::contact();
        $latitude = $contact['latitude'];
        $longitude = $contact['longitude'];
        $zoom = $contact['zoom'];
        
        return "https://www.google.com/maps?q={$latitude},{$longitude}&z={$zoom}&output=embed";
    }

    /**
     * Get Google Maps open URL
     */
    public static function mapsOpen(): string
    {
        $contact = self::contact();
        $mapsUrl = $contact['maps_url'] ?? '';
        $latitude = $contact['latitude'];
        $longitude = $contact['longitude'];
        $zoom = $contact['zoom'];
        
        return $mapsUrl ?: "https://www.google.com/maps?q={$latitude},{$longitude}&z={$zoom}";
    }

    /**
     * Get WhatsApp URL
     */
    public static function whatsappUrl(): string
    {
        $school = self::school();
        return "https://wa.me/{$school['whatsapp']}";
    }
}
