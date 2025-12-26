<?php

namespace App\Http\Controllers\Modules\EmergencyKit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emergency;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Immunisation;
use App\Models\Lab;

class CreateController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'type' => 'required|in:condition,medication,allergy,vaccination,lab',
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
            case 'vaccination':
                $modelClass = Immunisation::class;
                break;
            case 'lab':
                $modelClass = Lab::class;
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
}
