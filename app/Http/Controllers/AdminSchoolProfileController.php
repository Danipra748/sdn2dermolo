<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSchoolProfileController extends Controller
{
    /**
     * Display school profile edit page
     */
    public function edit()
    {
        $profile = SchoolProfile::getOrCreate();
        return view('admin.school-profile.edit', compact('profile'));
    }

    /**
     * Update school profile
     */
    public function update(Request $request)
    {
        $profile = SchoolProfile::getOrCreate();

        $validated = $request->validate([
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
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'land_area' => 'nullable|string|max:50',
            'total_classes' => 'nullable|integer|min:0',

            // Vision & Mission
            'vision' => 'nullable|string',
            'missions' => 'nullable|array',
            'mission_items' => 'nullable|array',

            // Logo
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Handle logo upload with production-ready error handling
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            // Validate file is valid
            if (!$file->isValid()) {
                return redirect()->back()
                    ->with('error', 'File upload gagal. Silakan coba lagi.');
            }
            
            // Delete old logo
            if ($profile->logo) {
                $oldPath = storage_path('app/public/' . $profile->logo);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            // Ensure directory exists (important for production)
            $directory = storage_path('app/public/school-profile');
            if (!is_dir($directory)) {
                mkdir($directory, 0775, true);
            }
            
            // Upload new logo
            $path = $file->store('school-profile', 'public');
            
            // Verify file was saved successfully
            $fullPath = storage_path('app/public/' . $path);
            if (!file_exists($fullPath)) {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan file. Periksa permission folder storage.');
            }
            
            // Set correct permissions for Linux production servers
            chmod($fullPath, 0664);
            
            $validated['logo'] = $path;
        }

        // Handle missions (from mission_items array)
        if ($request->has('mission_items')) {
            // Filter out empty mission items
            $missions = array_filter($request->input('mission_items'), function($item) {
                return !empty(trim($item));
            });
            $validated['missions'] = array_values($missions);
        }

        $profile->update($validated);

        return redirect()->route('admin.school-profile.edit')
            ->with('success', 'Profil sekolah berhasil diperbarui!');
    }

    /**
     * Delete logo
     */
    public function deleteLogo()
    {
        $profile = SchoolProfile::getOrCreate();

        if ($profile->logo) {
            // Delete file from storage
            $path = storage_path('app/public/' . $profile->logo);
            if (file_exists($path)) {
                @unlink($path);
            }
            
            $profile->update(['logo' => null]);
        }

        return response()->json(['success' => true]);
    }
}
