<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ExportConditionsController extends Controller
{
    /**
     * Export all medical conditions as PDF
     */
    public function exportPdf()
    {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Get patient information
        $patient = Auth::guard('patient')->user();

        // Get all conditions for this patient
        $conditions = Condition::where('patient_id', $patientId)
            ->orderBy('severity', 'desc')
            ->orderBy('diagnosis_date', 'desc')
            ->get();

        // Process conditions for display
        $processedConditions = $conditions->map(function ($condition) {
            return [
                'condition_name' => $condition->condition_name,
                'severity' => $condition->severity ?? 'Not specified',
                'status' => $condition->status ?? 'Not specified',
                'diagnosis_date' => $condition->diagnosis_date 
                    ? Carbon::parse($condition->diagnosis_date)->format('M d, Y') 
                    : 'Not recorded',
                'description' => $condition->description ?? 'No description provided',
                'treatment' => $condition->treatment ?? 'No treatment information',
                'notes' => $condition->notes ?? 'No additional notes',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.medicalCondition.exportPdf', [
            'patient' => $patient,
            'conditions' => $processedConditions,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalConditions' => $conditions->count(),
            'fileName' => 'Medical_Conditions_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
