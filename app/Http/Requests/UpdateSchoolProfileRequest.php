<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Basic Info
            'school_name' => 'nullable|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'school_status' => 'nullable|string|max:50',
            'accreditation' => 'nullable|string|max:10',

            // Address
            'address' => 'nullable|string',
            'village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',

            // Contact
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',

            // History & Stats
            'history_content' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'land_area' => 'nullable|string|max:50',
            'total_classes' => 'nullable|integer|min:0',

            // Vision & Mission
            'vision' => 'nullable|string',
            'missions' => 'nullable|array',
            'mission_items' => 'nullable|array',

            // Logo inputs
            'logo_raw' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_w' => 'nullable|numeric',
            'crop_h' => 'nullable|numeric',
        ];
    }
}
