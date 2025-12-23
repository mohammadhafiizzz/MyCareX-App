<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    // Show Admin Profile
    public function profile() {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    // Update Personal Details
    public function updatePersonal(Request $request) {
        $admin = auth()->guard('admin')->user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'ic_number' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->admin_id . ',admin_id',
        ]);

        $admin->update($request->only([
            'full_name', 'ic_number', 'phone_number', 'email'
        ]));

        return response()->json(['success' => true, 'message' => 'Personal details updated successfully.']);
    }

    // Update Profile Picture
    public function updatePicture(Request $request) {
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($admin->profile_image_url && file_exists(public_path($admin->profile_image_url))) {
                unlink(public_path($admin->profile_image_url));
            }
            
            $file = $request->file('profile_picture');
            $filename = $admin->admin_id . '_profile_picture.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/admin/profile'), $filename);
            
            $path = 'files/admin/profile/' . $filename;
            $admin->update(['profile_image_url' => $path]);

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
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json(['success' => false, 'message' => 'Current password does not match.'], 422);
        }

        $admin->update([
            'password' => $request->new_password
        ]);

        return response()->json(['success' => true, 'message' => 'Password updated successfully.']);
    }
}
