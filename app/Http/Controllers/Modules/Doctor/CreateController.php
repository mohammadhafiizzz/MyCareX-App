<?php

namespace App\Http\Controllers\Modules\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class CreateController extends Controller
{
    // CREATE: Add a new doctor
    public function store(Request $request) {
        // validation logic
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'ic_number' => 'required|string|max:20|unique:doctors,ic_number',
            'email' => 'required|email|max:100|unique:doctors,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'medical_license_number' => 'required|string|max:100|unique:doctors,medical_license_number',
            'specialisation' => 'nullable|in:General Practitioner,Cardiologist,Dermatologist,Neurologist,Pediatrician,Psychiatrist,Radiologist,Surgeon',
            'active_status' => 'nullable|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // get authenticated organisation id
        $organisationId = Auth::guard('organisation')->id();
        if (!$organisationId) {
            return redirect()->route('organisation.login');
        }

        // Prepare data
        $data = [
            'provider_id' => $organisationId,
            'full_name' => strtoupper($validated['full_name']),
            'ic_number' => str_replace('-', '', $validated['ic_number']),
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone_number' => '+60' . str_replace('-', '', $validated['phone_number']),
            'medical_license_number' => $validated['medical_license_number'],
            'specialisation' => $validated['specialisation'],
            'active_status' => $request->has('active_status') ? 1 : 0,
        ];

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $data['ic_number'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/doctor/profile'), $filename);
            $data['profile_image_url'] = 'files/doctor/profile/' . $filename;
        }

        // create new doctor record
        Doctor::create($data);
        
        return response()->json([
            'success' => true,
            'redirect' => route('organisation.doctors')
        ]);
    }
}
