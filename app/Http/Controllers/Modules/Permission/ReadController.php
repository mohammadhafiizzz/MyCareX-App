<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Patient;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Immunisation;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;

class ReadController extends Controller
{
    protected $methodController;

    public function __construct(MethodController $methodController)
    {
        $this->methodController = $methodController;
    }

    // READ: Show Permission Page (Patient)
    public function patientIndex() {
        $patient = Auth::guard('patient')->user();
        
        // Count providers with granted access
        $totalProvidersWithAccess = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->count();
        
        // Count pending access requests
        $pendingRequests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->count();

        // Get authorized doctors list
        $doctors = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->with(['doctor', 'provider'])
            ->orderBy('granted_at', 'desc')
            ->get();
        
        return view('patient.permission', compact(
            'totalProvidersWithAccess',
            'pendingRequests',
            'doctors'
        ));
    }

    // READ: Show View Permission Details (Patient)
    public function viewPermission($id) {
        $patient = Auth::guard('patient')->user();

        $permission = Permission::where('id', $id)
            ->where('patient_id', $patient->id)
            ->with(['doctor', 'provider'])
            ->firstOrFail();
    
        return view('patient.modules.permission.viewPermission', compact('permission'));
    }

    // READ: Show Pending Access Requests (Patient)
    public function patientRequests() {
        $patient = Auth::guard('patient')->user();
        
        $requests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with(['doctor', 'provider'])
            ->orderBy('requested_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.requests', compact('requests'));
    }

    // READ: Show Confirm Permission Page (Patient)
    public function showConfirmPermission($id) {
        $patient = Auth::guard('patient')->user();
        
        $permission = Permission::where('id', $id)
            ->where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with(['doctor', 'provider'])
            ->firstOrFail();
        
        return view('patient.modules.permission.confirmPermission', compact('permission'));
    }

    // READ: Show Full Activity History (Patient)
    public function patientActivity() {
        $patient = Auth::guard('patient')->user();
        
        // For now, return empty collection until tracking tables are implemented
        $activities = collect([]);
        
        return view('patient.modules.permission.activity', compact('activities'));
    }

    // READ: Show Permission Requests List (Doctor)
    public function doctorIndex(Request $request) {
        $doctor = Auth::guard('doctor')->user();

        // Get all permissions for client-side search and pagination
        $permissions = Permission::where('doctor_id', $doctor->id)
            ->with(['patient', 'provider'])
            ->orderBy('requested_at', 'desc')
            ->get();

        return view('doctor.modules.permission.request', [
            'permissions' => $permissions,
            'query' => null, // Query will be handled client-side
        ]);
    }

    // READ: Show Permission Request Details (Doctor)
    public function viewRequest($id) {
        $doctor = Auth::guard('doctor')->user();

        $permission = Permission::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->with(['patient', 'provider'])
            ->firstOrFail();
    
        return view('doctor.modules.permission.requestDetails', compact('permission'));
    }

    // READ: Display medical records page with statistics and records list (Doctor)
    public function medicalRecordIndex(Request $request)
    {
        $doctorId = Auth::guard('doctor')->id();
        
        // Get search term
        $search = $request->input('search', '');
        
        // Get all patients that the doctor has permission to access
        $permissions = Permission::where('doctor_id', $doctorId)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->with('patient')
            ->get();
        
        // Calculate statistics based on permissions
        $stats = [
            'conditions' => 0,
            'medications' => 0,
            'allergies' => 0,
            'immunisations' => 0,
            'labs' => 0
        ];
        
        $allRecords = collect();
        
        foreach ($permissions as $permission) {
            $patient = $permission->patient;
            if (!$patient) continue;
            
            $scope = $permission->permission_scope ?? [];
            
            // Check if scope allows access to each record type
            if ($this->methodController->hasPermissionScope($scope, 'medical_conditions')) {
                $conditions = $patient->conditions;
                $stats['conditions'] += $conditions->count();
                
                foreach ($conditions as $condition) {
                    $allRecords->push([
                        'type' => 'condition',
                        'id' => $condition->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'patient_image' => $patient->profile_image_url,
                        'name' => $condition->condition_name,
                        'date' => $condition->diagnosis_date,
                        'granted_at' => $permission->created_at,
                        'status' => $condition->status ?? 'N/A',
                        'severity' => $condition->severity ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->methodController->hasPermissionScope($scope, 'medications')) {
                $medications = $patient->medications;
                $stats['medications'] += $medications->count();
                
                foreach ($medications as $medication) {
                    $allRecords->push([
                        'type' => 'medication',
                        'id' => $medication->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'patient_image' => $patient->profile_image_url,
                        'name' => $medication->medication_name,
                        'date' => $medication->start_date,
                        'granted_at' => $permission->created_at,
                        'status' => $medication->status ?? 'N/A',
                        'dosage' => $medication->dosage . ' mg',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->methodController->hasPermissionScope($scope, 'allergies')) {
                $allergies = $patient->allergies;
                $stats['allergies'] += $allergies->count();
                
                foreach ($allergies as $allergy) {
                    $allRecords->push([
                        'type' => 'allergy',
                        'id' => $allergy->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'patient_image' => $patient->profile_image_url,
                        'name' => $allergy->allergen,
                        'date' => $allergy->first_observed_date,
                        'granted_at' => $permission->created_at,
                        'status' => $allergy->status ?? 'N/A',
                        'severity' => $allergy->severity ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->methodController->hasPermissionScope($scope, 'immunisations')) {
                $immunisations = $patient->immunisations;
                $stats['immunisations'] += $immunisations->count();
                
                foreach ($immunisations as $immunisation) {
                    $allRecords->push([
                        'type' => 'immunisation',
                        'id' => $immunisation->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'patient_image' => $patient->profile_image_url,
                        'name' => $immunisation->vaccine_name,
                        'date' => $immunisation->vaccination_date,
                        'granted_at' => $permission->created_at,
                        'administered_by' => $immunisation->administered_by ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->methodController->hasPermissionScope($scope, 'lab_tests')) {
                $labs = $patient->labs;
                $stats['labs'] += $labs->count();
                
                foreach ($labs as $lab) {
                    $allRecords->push([
                        'type' => 'lab',
                        'id' => $lab->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'patient_image' => $patient->profile_image_url,
                        'name' => $lab->test_name,
                        'date' => $lab->test_date,
                        'granted_at' => $permission->created_at,
                        'category' => $lab->test_category ?? 'N/A',
                        'facility' => $lab->facility_name ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
        }
        
        // Apply search filter
        if (!empty($search)) {
            $allRecords = $allRecords->filter(function($record) use ($search) {
                return stripos($record['patient_name'], $search) !== false ||
                       stripos($record['patient_ic'], $search) !== false ||
                       stripos($record['name'], $search) !== false;
            });
        }
        
        // Sort by date (most recent first)
        $allRecords = $allRecords->sortByDesc('date')->values();
        
        return view('doctor.modules.medicalRecord.medicalRecord', compact('stats', 'allRecords', 'search', 'permissions'));
    }    

     // READ: Show detailed view of a specific condition
    public function showCondition($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $condition = Condition::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->methodController->verifyRecordPermission($doctorId, $condition->patient_id, 'medical_conditions');
        
        return view('doctor.modules.medicalRecord.records.condition', compact('condition'));
    }
    
    // READ: Show detailed view of a specific medication
    public function showMedication($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $medication = Medication::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->methodController->verifyRecordPermission($doctorId, $medication->patient_id, 'medications');
        
        return view('doctor.modules.medicalRecord.records.medication', compact('medication'));
    }
    
    // READ: Show detailed view of a specific allergy
    public function showAllergy($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $allergy = Allergy::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->methodController->verifyRecordPermission($doctorId, $allergy->patient_id, 'allergies');
        
        return view('doctor.modules.medicalRecord.records.allergy', compact('allergy'));
    }
    
    // READ: Show detailed view of a specific immunisation
    public function showImmunisation($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $immunisation = Immunisation::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->methodController->verifyRecordPermission($doctorId, $immunisation->patient_id, 'immunisations');
        
        return view('doctor.modules.medicalRecord.records.immunisation', compact('immunisation'));
    }
    
    // READ: Show detailed view of a specific lab test
    public function showLab($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $lab = Lab::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->methodController->verifyRecordPermission($doctorId, $lab->patient_id, 'lab_tests');
        
        return view('doctor.modules.medicalRecord.records.lab', compact('lab'));
    }
}
