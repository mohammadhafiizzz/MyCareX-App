<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Permission;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Immunisation;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientRecordController extends Controller
{
    /**
     * Display medical records page with statistics and records list
     */
    public function index(Request $request)
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
            if ($this->hasPermission($scope, 'conditions')) {
                $conditions = $patient->conditions;
                $stats['conditions'] += $conditions->count();
                
                foreach ($conditions as $condition) {
                    $allRecords->push([
                        'type' => 'condition',
                        'id' => $condition->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'name' => $condition->condition_name,
                        'date' => $condition->diagnosis_date,
                        'status' => $condition->status ?? 'N/A',
                        'severity' => $condition->severity ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->hasPermission($scope, 'medications')) {
                $medications = $patient->medications;
                $stats['medications'] += $medications->count();
                
                foreach ($medications as $medication) {
                    $allRecords->push([
                        'type' => 'medication',
                        'id' => $medication->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'name' => $medication->medication_name,
                        'date' => $medication->start_date,
                        'status' => $medication->status ?? 'N/A',
                        'dosage' => $medication->dosage . ' mg',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->hasPermission($scope, 'allergies')) {
                $allergies = $patient->allergies;
                $stats['allergies'] += $allergies->count();
                
                foreach ($allergies as $allergy) {
                    $allRecords->push([
                        'type' => 'allergy',
                        'id' => $allergy->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'name' => $allergy->allergen,
                        'date' => $allergy->first_observed_date,
                        'status' => $allergy->status ?? 'N/A',
                        'severity' => $allergy->severity ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->hasPermission($scope, 'immunisations')) {
                $immunisations = $patient->immunisations;
                $stats['immunisations'] += $immunisations->count();
                
                foreach ($immunisations as $immunisation) {
                    $allRecords->push([
                        'type' => 'immunisation',
                        'id' => $immunisation->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'name' => $immunisation->vaccine_name,
                        'date' => $immunisation->vaccination_date,
                        'administered_by' => $immunisation->administered_by ?? 'N/A',
                        'patient_id' => $patient->id
                    ]);
                }
            }
            
            if ($this->hasPermission($scope, 'labs')) {
                $labs = $patient->labs;
                $stats['labs'] += $labs->count();
                
                foreach ($labs as $lab) {
                    $allRecords->push([
                        'type' => 'lab',
                        'id' => $lab->id,
                        'patient_name' => $patient->full_name,
                        'patient_ic' => $patient->ic_number,
                        'name' => $lab->test_name,
                        'date' => $lab->test_date,
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
        
        return view('doctor.modules.patient.medicalRecord', compact('stats', 'allRecords', 'search'));
    }
    
    /**
     * Check if permission scope allows access to a specific record type
     */
    private function hasPermission($scope, $type)
    {
        // If scope is empty or null, deny access
        if (empty($scope)) {
            return false;
        }
        
        // If scope contains 'all', grant access to everything
        if (in_array('all', $scope)) {
            return true;
        }
        
        // Check if specific type is in scope
        return in_array($type, $scope);
    }
    
    /**
     * Show detailed view of a specific condition
     */
    public function showCondition($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $condition = Condition::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->verifyPermission($doctorId, $condition->patient_id, 'conditions');
        
        return view('doctor.modules.patient.records.condition', compact('condition'));
    }
    
    /**
     * Show detailed view of a specific medication
     */
    public function showMedication($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $medication = Medication::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->verifyPermission($doctorId, $medication->patient_id, 'medications');
        
        return view('doctor.modules.patient.records.medication', compact('medication'));
    }
    
    /**
     * Show detailed view of a specific allergy
     */
    public function showAllergy($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $allergy = Allergy::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->verifyPermission($doctorId, $allergy->patient_id, 'allergies');
        
        return view('doctor.modules.patient.records.allergy', compact('allergy'));
    }
    
    /**
     * Show detailed view of a specific immunisation
     */
    public function showImmunisation($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $immunisation = Immunisation::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->verifyPermission($doctorId, $immunisation->patient_id, 'immunisations');
        
        return view('doctor.modules.patient.records.immunisation', compact('immunisation'));
    }
    
    /**
     * Show detailed view of a specific lab test
     */
    public function showLab($id)
    {
        $doctorId = Auth::guard('doctor')->id();
        $lab = Lab::with('patient', 'doctor')->findOrFail($id);
        
        // Verify permission
        $this->verifyPermission($doctorId, $lab->patient_id, 'labs');
        
        return view('doctor.modules.patient.records.lab', compact('lab'));
    }
    
    /**
     * Verify if doctor has permission to access specific record type for a patient
     */
    private function verifyPermission($doctorId, $patientId, $recordType)
    {
        $permission = Permission::where('doctor_id', $doctorId)
            ->where('patient_id', $patientId)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->first();
        
        if (!$permission) {
            abort(403, 'You do not have permission to access this record.');
        }
        
        $scope = $permission->permission_scope ?? [];
        
        if (!$this->hasPermission($scope, $recordType)) {
            abort(403, 'You do not have permission to access this type of record.');
        }
        
        return true;
    }
}
