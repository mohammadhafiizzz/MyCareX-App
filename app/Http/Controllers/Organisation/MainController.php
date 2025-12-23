<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    // Show Organisation Dashboard
    public function index() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';

        return view('organisation.dashboard', compact('organisation', 'isVerified'));
    }

    public function profile() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';
        return view('organisation.profile', compact('organisation', 'isVerified'));
    }

    public function settings() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';
        return view('organisation.settings', compact('organisation', 'isVerified'));
    }

    // Update Organisation Details
    public function updateDetails(Request $request) {
        $organisation = auth()->guard('organisation')->user();
        
        $request->validate([
            'organisation_name' => 'required|string|max:255',
            'organisation_type' => 'required|string|max:255',
            'establishment_date' => 'nullable|date',
            'website_url' => 'nullable|url|max:255',
        ]);

        $organisation->update($request->only([
            'organisation_name', 'organisation_type', 'establishment_date', 'website_url'
        ]));

        return response()->json(['success' => true, 'message' => 'Organisation details updated successfully.']);
    }

    // Update Contact & Location
    public function updateContact(Request $request) {
        $organisation = auth()->guard('organisation')->user();

        $request->validate([
            'phone_number' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:10',
            'state' => 'required|string|max:100',
        ]);

        $organisation->update($request->only([
            'phone_number', 'emergency_contact', 'address', 'postal_code', 'state'
        ]));

        return response()->json(['success' => true, 'message' => 'Contact details updated successfully.']);
    }

    // Update Person In Charge (PIC)
    public function updatePic(Request $request) {
        $organisation = auth()->guard('organisation')->user();

        $request->validate([
            'contact_person_name' => 'required|string|max:255',
            'contact_person_designation' => 'required|string|max:255',
            'contact_person_phone_number' => 'required|string|max:20',
            'contact_person_ic_number' => 'required|string|max:20',
        ]);

        $organisation->update($request->only([
            'contact_person_name', 'contact_person_designation', 
            'contact_person_phone_number', 'contact_person_ic_number'
        ]));

        return response()->json(['success' => true, 'message' => 'PIC details updated successfully.']);
    }

    // Update Legal & Licensing
    public function updateLegal(Request $request) {
        $organisation = auth()->guard('organisation')->user();

        $request->validate([
            'registration_number' => 'required|string|max:50',
            'license_number' => 'nullable|string|max:50',
            'license_expiry_date' => 'nullable|date',
            'business_license_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'medical_license_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['registration_number', 'license_number', 'license_expiry_date']);

        if ($request->hasFile('business_license_document')) {
            // Delete old file if exists
            if ($organisation->business_license_document && file_exists(public_path($organisation->business_license_document))) {
                unlink(public_path($organisation->business_license_document));
            }
            
            $file = $request->file('business_license_document');
            $filename = $organisation->id . '_business_license_document.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/organisation/business_license'), $filename);
            $data['business_license_document'] = 'files/organisation/business_license/' . $filename;
        }

        if ($request->hasFile('medical_license_document')) {
            // Delete old file if exists
            if ($organisation->medical_license_document && file_exists(public_path($organisation->medical_license_document))) {
                unlink(public_path($organisation->medical_license_document));
            }
            
            $file = $request->file('medical_license_document');
            $filename = $organisation->id . '_medical_license_document.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/organisation/medical_license'), $filename);
            $data['medical_license_document'] = 'files/organisation/medical_license/' . $filename;
        }

        $organisation->update($data);

        return response()->json(['success' => true, 'message' => 'Legal details updated successfully.']);
    }

    // Update Profile Picture
    public function updatePicture(Request $request) {
        $organisation = auth()->guard('organisation')->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($organisation->profile_image_url && file_exists(public_path($organisation->profile_image_url))) {
                unlink(public_path($organisation->profile_image_url));
            }
            
            $file = $request->file('profile_picture');
            $filename = $organisation->id . '_profile_picture.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/organisation/profile'), $filename);
            
            $path = 'files/organisation/profile/' . $filename;
            $organisation->update(['profile_image_url' => $path]);

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
        $organisation = auth()->guard('organisation')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $organisation->password)) {
            return response()->json(['success' => false, 'message' => 'Current password does not match.'], 422);
        }

        $organisation->update([
            'password' => $request->new_password
        ]);

        return response()->json(['success' => true, 'message' => 'Password updated successfully.']);
    }
}
