<?php

namespace App\Http\Controllers\Modules\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class UpdateController extends Controller
{
    // UPDATE: Update doctor details
    public function update(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);

        // validation logic
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'ic_number' => 'required|string|max:20|unique:doctors,ic_number,' . $id,
            'email' => 'required|email|max:100|unique:doctors,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'medical_license_number' => 'required|string|max:100|unique:doctors,medical_license_number,' . $id,
            'specialisation' => 'nullable|in:General Practitioner,Cardiologist,Dermatologist,Neurologist,Pediatrician,Psychiatrist,Radiologist,Surgeon',
            'active_status' => 'nullable|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Prepare data
        $data = [
            'full_name' => strtoupper($validated['full_name']),
            'ic_number' => str_replace('-', '', $validated['ic_number']),
            'email' => $validated['email'],
            'phone_number' => '+60' . str_replace('-', '', $validated['phone_number']),
            'medical_license_number' => $validated['medical_license_number'],
            'specialisation' => $validated['specialisation'],
            'active_status' => $request->has('active_status') ? 1 : 0,
        ];

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($doctor->profile_image_url && file_exists(public_path($doctor->profile_image_url))) {
                unlink(public_path($doctor->profile_image_url));
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . $data['ic_number'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/doctor/profile'), $filename);
            $data['profile_image_url'] = 'files/doctor/profile/' . $filename;
        }

        // update doctor record
        $doctor->update($data);
        
        return response()->json([
            'success' => true,
            'redirect' => route('organisation.doctor.profile', $id)
        ]);
    }
}
