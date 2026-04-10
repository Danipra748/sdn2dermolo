<?php

/**
 * Static School Configuration
 * 
 * This file contains hardcoded configuration data for Contact School 
 * and Homepage Settings that were previously stored in the database.
 * These values are now static for better performance and simplicity.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Contact School Information
    |--------------------------------------------------------------------------
    |
    | All contact information for the school is stored here statically.
    | This includes address, phone, email, and map coordinates.
    |
    */

    'contact' => [
        'address' => "Desa Dermolo, Kecamatan Kembang\nKabupaten Jepara, Provinsi Jawa Tengah",
        'phone' => '0896-6898-2633',
        'email' => 'sdndermolo728@gmail.com',
        'maps_url' => 'https://maps.app.goo.gl/fSzY2sUbFbfXHvbj7', // Verified Google Maps link to SD N 2 Dermolo
        'latitude' => -6.82936,
        'longitude' => 110.65444,
        'zoom' => 17,
        'operating_hours' => [
            'weekdays' => 'Senin - Jumat: 07.00 - 14.00 WIB',
            'saturday' => 'Sabtu: 07.00 - 13.00 WIB',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Homepage Settings (Hero Section)
    |--------------------------------------------------------------------------
    |
    | Hero section configuration for the homepage. This includes the
    | title, subtitle, description, and slideshow settings.
    |
    */

    'homepage' => [
        'hero' => [
            'is_active' => true,
            'title' => 'Sekolah yang',
            'subtitle' => 'Membentuk',
            'description' => null, // Will use default if null
            'badge_text' => 'SELAMAT DATANG DI SD N 2 DERMolo',
            'background_overlay_opacity' => 0.35,
            'background_image' => null, // Path to primary background image
            'slideshow_images' => [], // Array of slideshow images
            'slide_texts' => [], // Per-slide text overlays
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | School Profile (Additional Static Data)
    |--------------------------------------------------------------------------
    |
    | Additional school information that remains static.
    |
    */

    'school' => [
        'name' => 'SD N 2 Dermolo',
        'full_name' => 'Sekolah Dasar Negeri 2 Dermolo',
        'address_full' => 'Desa Dermolo RT. 03 RW. 01, Kecamatan Kembang, Kabupaten Jepara, Provinsi Jawa Tengah',
        'district' => 'Kembang',
        'regency' => 'Jepara',
        'province' => 'Jawa Tengah',
        'whatsapp' => '6289668982633', // Format: country code + number without +
    ],
];
