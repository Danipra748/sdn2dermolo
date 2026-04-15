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
        try {
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

                // Logo - always nullable to allow re-upload
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            // Handle logo upload - only process if file is present
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');

                if (!$file->isValid()) {
                    return redirect()->back()
                        ->with('error', 'File upload gagal. File tidak valid.');
                }

                // Delete old logo if exists (using base controller method)
                if ($profile->logo) {
                    $this->deletePhysicalFile($profile->logo, 'public');
                }

                // Ensure directory exists
                $directory = storage_path('app/public/school-profile');
                if (!is_dir($directory)) {
                    mkdir($directory, 0775, true);
                }

                // Upload new logo
                $path = $file->store('school-profile', 'public');
                $validated['logo'] = $path;

                // Set correct permissions
                $fullPath = storage_path('app/public/' . $path);
                if (file_exists($fullPath)) {
                    chmod($fullPath, 0664);
                }
            }

            // Handle missions (from mission_items array)
            if ($request->has('mission_items')) {
                $missions = array_filter($request->input('mission_items'), function($item) {
                    return !empty(trim($item));
                });
                $validated['missions'] = array_values($missions);
            }

            // Update profile - only update fields that were sent
            $profile->update($validated);

            return redirect()->route('admin.school-profile.edit')
                ->with('success', 'Profil sekolah berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('School profile update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Delete logo (set to null, don't delete row)
     */
    public function deleteLogo()
    {
        $profile = SchoolProfile::getOrCreate();

        if ($profile->logo) {
            // Delete file from storage (using base controller method)
            $this->deletePhysicalFile($profile->logo, 'public');

            // Set logo to null (DON'T delete row)
            $profile->update(['logo' => null]);
        }

        return response()->json(['success' => true]);
    }
}
