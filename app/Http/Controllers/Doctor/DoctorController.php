<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // show dashboard
    public function index() {
        return view('doctor.dashboard');
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

        return view('doctor.modules.patient.viewProfile', [
            'patient' => $patient,
        ]);
    }

    // search patient result page
    public function searchPatientResult(Request $request) {
        $query = trim($request->input('query', ''));

        if ($query === '') {
            return redirect()->route('doctor.patient.search')
                ->withErrors(['query' => 'Enter a patient name or identification number to search.'])
                ->withInput();
        }

        $patients = Patient::search($query)
            ->orderBy('full_name')
            ->paginate(12)
            ->withQueryString();

        return view('doctor.modules.patient.searchPatient', [
            'patients' => $patients,
            'query' => $query,
        ]);
    }
}
