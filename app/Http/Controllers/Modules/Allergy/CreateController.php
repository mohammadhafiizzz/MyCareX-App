<?php

namespace App\Http\Controllers\Modules\Allergy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allergy;
use Illuminate\Support\Facades\Auth;

use App\Models\Permission;

class CreateController extends Controller
{
    // Show Doctor Add Allergy Form
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
            if (in_array('all', $scope) || in_array('allergies', $scope)) {
                if ($permission->patient) {
                    $patients->push($permission->patient);
                }
            }
        }
        
        return view('doctor.modules.medicalRecord.create.addAllergy', compact('patients'));
    }

    // Store allergy by Doctor
    public function storeDoctor(Request $request) {
        $doctorId = Auth::guard('doctor')->id();

        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
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
        if (!in_array('all', $scope) && !in_array('allergies', $scope)) {
            return redirect()->back()->with('error', 'You do not have permission to add allergies for this patient.');
        }

        // Add doctor_id
        $validatedData['doctor_id'] = $doctorId;

        // Create new allergy record
        Allergy::create($validatedData);

        return redirect()->route('doctor.medical.records')->with('success', 'Allergy added successfully');
    }

    /**
     * Store a newly created allergy.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new allergy record
        Allergy::create($validatedData);

        // Return back with success message
        return redirect()->back()->with('message', 'Allergy added successfully');
    }
}
