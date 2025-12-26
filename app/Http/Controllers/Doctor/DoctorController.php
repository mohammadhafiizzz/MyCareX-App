<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // show dashboard
    public function index() {
        return view('doctor.dashboard');
    }

    // show all patients who granted access to the doctor
    public function patients() {
        $doctorId = Auth::guard('doctor')->id();
        
        // Get all patients who have granted access to this doctor
        $patients = Patient::whereHas('permissions', function($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId)
                  ->where('status', 'Active');
        })->with(['permissions' => function($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }])->orderBy('full_name', 'asc')->get();

        return view('doctor.modules.patient.patient', [
            'patients' => $patients,
        ]);
    }

    // view detailed patient information with medical records
    public function viewPatient($patientId) {
        $doctorId = Auth::guard('doctor')->id();
        
        // Check if doctor has permission to view this patient
        $permission = Permission::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->where('status', 'Active')
            ->first();

        if (!$permission) {
            return redirect()->route('doctor.patients')
                ->with('error', 'You do not have permission to view this patient\'s information.');
        }

        $scope = $permission->permission_scope ?? [];
        $isAll = in_array('all', $scope);

        // Build query with conditional relationships based on scope
        $patientQuery = Patient::query();

        if ($isAll || in_array('medical_conditions', $scope)) {
            $patientQuery->with('conditions');
        }
        if ($isAll || in_array('medications', $scope)) {
            $patientQuery->with('medications');
        }
        if ($isAll || in_array('allergies', $scope)) {
            $patientQuery->with('allergies');
        }
        if ($isAll || in_array('immunisations', $scope)) {
            $patientQuery->with('immunisations');
        }
        if ($isAll || in_array('lab_tests', $scope)) {
            $patientQuery->with('labs');
        }

        $patient = $patientQuery->findOrFail($patientId);

        return view('doctor.modules.patient.patientProfile', [
            'patient' => $patient,
            'permission' => $permission,
            'scope' => $scope,
            'isAll' => $isAll
        ]);
    }

    // search patient page
    public function searchPatient() {
        return view('doctor.modules.patient.searchPatient', [
            'patients' => null,
            'query' => null,
        ]);
    }

    // view patient profile
    public function viewPatientProfile($patientId) {
        $patient = Patient::findOrFail($patientId);
        $doctorId = Auth::guard('doctor')->id();

        $hasRequestedAccess = Permission::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->whereIn('status', ['Pending', 'Active'])
            ->exists();

        return view('doctor.modules.patient.viewProfile', [
            'patient' => $patient,
            'hasRequestedAccess' => $hasRequestedAccess,
        ]);
    }

    // search patient result page
    public function searchPatientResult(Request $request) {
        $query = trim($request->input('query', ''));
        $doctorId = Auth::guard('doctor')->id();

        if ($query === '') {
            return redirect()->route('doctor.patient.search')
                ->withErrors(['query' => 'Enter a patient identification number to search.'])
                ->withInput();
        }

        $patients = Patient::search($query)
            ->orderBy('full_name')
            ->paginate(12)
            ->withQueryString();

        // Check for existing permissions for each patient
        $patients->getCollection()->transform(function ($patient) use ($doctorId) {
            $patient->has_requested_access = Permission::where('patient_id', $patient->id)
                ->where('doctor_id', $doctorId)
                ->whereIn('status', ['Pending', 'Active'])
                ->exists();
            return $patient;
        });

        return view('doctor.modules.patient.searchPatient', [
            'patients' => $patients,
            'query' => $query,
        ]);
    }
}
