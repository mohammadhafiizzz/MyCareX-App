<?php

namespace App\Http\Controllers\Modules\EmergencyKit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emergency;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;

class EmergencyKitController extends Controller
{
    public function index() {
        $patient = Auth::guard('patient')->user();
        
        // Eager load the polymorphic relation 'record'
        $emergencyItems = Emergency::where('patient_id', $patient->id)
            ->with('record')
            ->get();

        // Check if emergency kit is empty
        $isEmpty = $emergencyItems->isEmpty();

        // Group items by type for cleaner view logic
        $conditions = $emergencyItems->where('record_type', Condition::class);
        $medications = $emergencyItems->where('record_type', Medication::class);
        $allergies = $emergencyItems->where('record_type', Allergy::class);

        return view('patient.modules.emergencyKit.index', compact(
            'patient', 
            'emergencyItems', 
            'isEmpty',
            'conditions',
            'medications',
            'allergies'
        ));
    }

    public function create() {
        $patient = Auth::guard('patient')->user();
        return view('patient.modules.emergencyKit.create', compact('patient'));
    }

    public function fetchRecords(Request $request) {
        $patient = Auth::guard('patient')->user();
        $type = $request->input('type');
        $records = [];

        switch ($type) {
            case 'condition':
                // Fetch conditions not already in emergency kit
                $existingIds = Emergency::where('patient_id', $patient->id)
                    ->where('record_type', Condition::class)
                    ->pluck('record_id');
                
                $records = Condition::where('patient_id', $patient->id)
                    ->whereNotIn('id', $existingIds)
                    ->select('id', 'condition_name as name', 'severity') // Standardize output
                    ->get();
                break;

            case 'medication':
                $existingIds = Emergency::where('patient_id', $patient->id)
                    ->where('record_type', Medication::class)
                    ->pluck('record_id');

                $records = Medication::where('patient_id', $patient->id)
                    ->whereNotIn('id', $existingIds)
                    ->select('id', 'medication_name as name', 'dosage')
                    ->get();
                break;

            case 'allergy':
                $existingIds = Emergency::where('patient_id', $patient->id)
                    ->where('record_type', Allergy::class)
                    ->pluck('record_id');

                $records = Allergy::where('patient_id', $patient->id)
                    ->whereNotIn('id', $existingIds)
                    ->select('id', 'allergen as name', 'severity')
                    ->get();
                break;
        }

        return response()->json($records);
    }

    public function store(Request $request) {
        $request->validate([
            'type' => 'required|in:condition,medication,allergy',
            'record_id' => 'required|integer',
        ]);

        $patient = Auth::guard('patient')->user();
        $type = $request->input('type');
        $recordId = $request->input('record_id');
        $modelClass = null;

        // Determine Model Class
        switch ($type) {
            case 'condition':
                $modelClass = Condition::class;
                break;
            case 'medication':
                $modelClass = Medication::class;
                break;
            case 'allergy':
                $modelClass = Allergy::class;
                break;
        }

        // Validation: Check if record belongs to patient
        $record = $modelClass::where('id', $recordId)
            ->where('patient_id', $patient->id)
            ->first();

        if (!$record) {
            return back()->withErrors(['msg' => 'Invalid record selected or access denied.']);
        }

        // Check if already exists in Emergency Kit
        $exists = Emergency::where('patient_id', $patient->id)
            ->where('record_type', $modelClass)
            ->where('record_id', $recordId)
            ->exists();

        if ($exists) {
            return back()->withErrors(['msg' => 'This item is already in your Emergency Kit.']);
        }

        // Create Emergency Record
        Emergency::create([
            'patient_id' => $patient->id,
            'record_type' => $modelClass,
            'record_id' => $recordId,
        ]);

        return redirect()->route('patient.emergency-kit.index')->with('success', 'Item added to Emergency Kit successfully.');
    }

    public function destroy($id) {
        $patient = Auth::guard('patient')->user();
        
        $emergencyItem = Emergency::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $emergencyItem->delete();

        return redirect()->route('patient.emergency-kit.index')->with('success', 'Item removed from Emergency Kit.');
    }
}
