<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Permission;

class AddConditionController extends Controller
{
    // Show Doctor Add Condition Form
    public function showDoctorForm() {
        $doctorId = Auth::guard('doctor')->id();
        
        // Get patients that the doctor has permission to add conditions for
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
            if (in_array('all', $scope) || in_array('medical_conditions', $scope)) {
                if ($permission->patient) {
                    $patients->push($permission->patient);
                }
            }
        }
        
        return view('doctor.modules.medicalRecord.create.addCondition', compact('patients'));
    }

    // Store condition by Doctor
    public function storeDoctor(Request $request) {
        $doctorId = Auth::guard('doctor')->id();

        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'condition_name' => 'required|string|max:255',
            'diagnosis_date' => 'nullable|date',
            'description' => 'nullable|string',
            'severity' => 'required|in:Mild,Moderate,Severe',
            'status' => 'required|in:Active,Resolved,Chronic',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
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
        if (!in_array('all', $scope) && !in_array('medical_conditions', $scope)) {
            return redirect()->back()->with('error', 'You do not have permission to add medical conditions for this patient.');
        }

        // Add doctor_id
        $validatedData['doctor_id'] = $doctorId;

        // Create new condition record
        $condition = Condition::create($validatedData);

        // Handle optional file upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');
                $destinationPath = public_path('files/medicalCondition');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $conditionId = $condition->id;
                $baseName = 'Condition_' . $conditionId . '_Attachment';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                $file->move($destinationPath, $filename);
                $publicUrl = asset('files/medicalCondition/' . $filename);

                $condition->doc_attachments_url = $publicUrl;
                $condition->save();
            } catch (\Exception $e) {
                return redirect()->route('doctor.medical.records')->with('warning', 'Medical condition added successfully, but attachment upload failed.');
            }
        }

        return redirect()->route('doctor.medical.records')->with('success', 'Medical condition added successfully');
    }

    // Add new medical condition for a patient
    public function add(Request $request) {
        $validatedData = $request->validate([
            'condition_name' => 'required|string|max:255',
            'diagnosis_date' => 'nullable|date',
            'description' => 'nullable|string',
            'severity' => 'required|in:Mild,Moderate,Severe',
            'status' => 'required|in:Active,Resolved,Chronic',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Optional attachment, max 10MB
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new condition record
        $condition = Condition::create($validatedData);

        // Handle optional file upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');

                // Target directory in public path
                $destinationPath = public_path('files/medicalCondition');

                // Ensure directory exists
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Build filename: Condition_{CONDITION_ID}_Attachment.{ext}
                $conditionId = $condition->id;
                $baseName = 'Condition_' . $conditionId . '_Attachment';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                // Move file into public/files/medicalCondition
                $file->move($destinationPath, $filename);

                // Build the public URL to store in DB
                $publicUrl = asset('images/medicalCondition/' . $filename);

                // Update the condition with attachment URL
                $condition->doc_attachments_url = $publicUrl;
                $condition->save();
            } catch (\Exception $e) {
                // If file upload fails, still create the condition but notify user
                return redirect()->back()->with('warning', 'Medical condition added successfully, but attachment upload failed.');
            }
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Medical condition added successfully');
    }
}
