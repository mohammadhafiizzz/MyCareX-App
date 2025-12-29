<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Permission;

class AddMedicationController extends Controller
{
    // Show Doctor Add Medication Form
    public function showDoctorForm() {
        $doctorId = Auth::guard('doctor')->id();
        
        $permissions = Permission::where('doctor_id', $doctorId)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->with('patient')
            ->get();
            
        $patients = collect();
        
        foreach ($permissions as $permission) {
            $scope = $permission->permission_scope ?? [];
            if (in_array('all', $scope) || in_array('medications', $scope)) {
                if ($permission->patient) {
                    $patients->push($permission->patient);
                }
            }
        }
        
        return view('doctor.modules.medicalRecord.create.addMedication', compact('patients'));
    }

    // Store medication by Doctor
    public function storeDoctor(Request $request) {
        $doctorId = Auth::guard('doctor')->id();

        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|integer|min:1|max:999999',
            'frequency_times' => 'required|integer|min:1|max:24',
            'frequency_period' => 'required|in:daily,weekly,monthly',
            'frequency' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Active,On Hold,Completed,Discontinued',
            'reason_for_med' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Verify Permission
        $permission = Permission::where('doctor_id', $doctorId)
            ->where('patient_id', $request->patient_id)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->first();

        if (!$permission) {
            return redirect()->back()->with('error', 'You do not have permission to access this patient\'s records.');
        }

        $scope = $permission->permission_scope ?? [];
        if (!in_array('all', $scope) && !in_array('medications', $scope)) {
            return redirect()->back()->with('error', 'You do not have permission to add medications for this patient.');
        }

        // Remove temp fields
        unset($validatedData['frequency_times'], $validatedData['frequency_period']);

        // Add doctor_id
        $validatedData['doctor_id'] = $doctorId;

        // Create new medication record
        $medication = Medication::create($validatedData);

        // Handle optional image upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');
                $destinationPath = public_path('images/medication');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $medicationId = $medication->id;
                $baseName = 'Medication_' . $medicationId . '_Image';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                $file->move($destinationPath, $filename);
                $publicUrl = asset('images/medication/' . $filename);

                $medication->med_image_url = $publicUrl;
                $medication->save();
            } catch (\Exception $e) {
                return redirect()->route('doctor.medical.records')->with('warning', 'Medication added successfully, but image upload failed.');
            }
        }

        return redirect()->route('doctor.medical.records')->with('success', 'Medication added successfully');
    }

    // Add new medication for a patient
    public function add(Request $request) {
        $validatedData = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|integer|min:1|max:999999',
            'frequency_times' => 'required|integer|min:1|max:24',
            'frequency_period' => 'required|in:daily,weekly,monthly',
            'frequency' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Active,On Hold,Completed,Discontinued',
            'reason_for_med' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Only images, max 10MB
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Remove the temporary fields, only store the combined frequency
        unset($validatedData['frequency_times'], $validatedData['frequency_period']);
        
        $validatedData['patient_id'] = $patientId;

        // Create new medication record
        $medication = Medication::create($validatedData);

        // Handle optional image upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');

                // Target directory in public path
                $destinationPath = public_path('images/medication');

                // Ensure directory exists
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Build filename: Medication_{MEDICATION_ID}_Image.{ext}
                $medicationId = $medication->id;
                $baseName = 'Medication_' . $medicationId . '_Image';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                // Move file into public/images/medication
                $file->move($destinationPath, $filename);

                // Build the public URL to store in DB
                $publicUrl = asset('images/medication/' . $filename);

                // Update the medication with image URL
                $medication->med_image_url = $publicUrl;
                $medication->save();
            } catch (\Exception $e) {
                // If file upload fails, still create the medication but notify user
                return redirect()->back()->with('warning', 'Medication added successfully, but image upload failed.');
            }
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Medication added successfully');
    }
}
