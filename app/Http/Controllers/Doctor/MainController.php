<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    // Show Doctor Profile
    public function profile() {
        $doctor = Auth::guard('doctor')->user();
        // Load the provider relationship
        $doctor->load('provider');
        return view('doctor.profile', compact('doctor'));
    }

    // Update Personal Details
    public function updatePersonal(Request $request) {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'ic_number' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:doctors,email,' . $doctor->id,
            'medical_license_number' => 'required|string|max:50',
            'specialisation' => 'required|string|max:100',
        ]);

        $doctor->update($request->only([
            'full_name', 'ic_number', 'phone_number', 'email', 'medical_license_number', 'specialisation'
        ]));

        return response()->json(['success' => true, 'message' => 'Personal details updated successfully.']);
    }

    // Update Profile Picture
    public function updatePicture(Request $request) {
        $doctor = Auth::guard('doctor')->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($doctor->profile_image_url && file_exists(public_path($doctor->profile_image_url))) {
                unlink(public_path($doctor->profile_image_url));
            }
            
            $file = $request->file('profile_picture');
            $filename = $doctor->id . '_profile_picture.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/doctor/profile'), $filename);
            
            $path = 'files/doctor/profile/' . $filename;
            $doctor->update(['profile_image_url' => $path]);

            return response()->json([
                'success' => true, 
                'message' => 'Profile picture updated successfully.',
                'url' => asset($path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No image uploaded.'], 400);
    }

    // Update Password
    public function updatePassword(Request $request) {
        $doctor = Auth::guard('doctor')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $doctor->password)) {
            return response()->json(['success' => false, 'message' => 'Current password does not match.'], 422);
        }

        $doctor->update([
            'password' => $request->new_password
        ]);

        return response()->json(['success' => true, 'message' => 'Password updated successfully.']);
    }
}
