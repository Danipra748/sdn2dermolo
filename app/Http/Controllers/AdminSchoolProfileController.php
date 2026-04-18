<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use App\Services\Modules\SchoolProfileService;
use App\Http\Requests\UpdateSchoolProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSchoolProfileController extends Controller
{
    protected $schoolProfileService;

    public function __construct(SchoolProfileService $schoolProfileService)
    {
        $this->schoolProfileService = $schoolProfileService;
    }

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
    public function update(UpdateSchoolProfileRequest $request)
    {
        try {
            $this->schoolProfileService->updateProfile($request);

            return redirect()->route('admin.school-profile.edit')
                ->with('success', 'Profil sekolah berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('School profile update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Delete school logo
     */
    public function deleteLogo()
    {
        $success = $this->schoolProfileService->deleteLogo();
        return response()->json(['success' => $success]);
    }
}
