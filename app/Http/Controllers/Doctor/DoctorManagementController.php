<?php

namespace App\Http\Controllers\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class DoctorManagementController extends Controller
{
    // handle adding a new doctor
    public function addDoctor(Request $request) {
        // validation logic
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'ic_number' => 'required|string|max:20|unique:doctors,ic_number',
            'email' => 'required|email|max:100|unique:doctors,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'medical_license_number' => 'required|string|max:100|unique:doctors,medical_license_number',
            'specialisation' => 'nullable|in:General Practitioner,Cardiologist,Dermatologist,Neurologist,Pediatrician,Psychiatrist,Radiologist,Surgeon',
            'active_status' => 'required|boolean',
            'profile_image_url' => 'nullable|url',
        ]);   

        // get authenticated organisation id
        $organisation = Auth::guard('organisation')->id() ?? Auth::id();
        if (!$organisation) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validated['provider_id'] = $organisation;

        $doctor = Doctor::create($validated);
        return response()->json(['message' => 'Doctor added successfully', 'doctor' => $doctor], 201);
    }
}