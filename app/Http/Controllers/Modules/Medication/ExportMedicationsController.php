<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ExportMedicationsController extends Controller
{
    /**
     * Export all medications as PDF
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

        // Get all medications for this patient
        $medications = Medication::where('patient_id', $patientId)
            ->orderBy('status', 'asc')
            ->orderBy('start_date', 'desc')
            ->get();

        // Process medications for display
        $processedMedications = $medications->map(function ($medication) {
            return [
                'medication_name' => $medication->medication_name,
                'dosage' => $medication->formatted_dosage,
                'frequency' => $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified',
                'status' => $medication->status ?? 'Not specified',
                'start_date' => $medication->start_date 
                    ? Carbon::parse($medication->start_date)->format('M d, Y') 
                    : 'Not scheduled',
                'end_date' => $medication->end_date 
                    ? Carbon::parse($medication->end_date)->format('M d, Y') 
                    : 'No end date',
                'reason_for_med' => $medication->reason_for_med ?? 'Not specified',
                'notes' => $medication->notes ?? 'No additional notes',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.medication.exportPdf', [
            'patient' => $patient,
            'medications' => $processedMedications,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalMedications' => $medications->count(),
            'fileName' => 'Medications_' . Carbon::now()->format('Y-m-d'),
        ]);
    }

    // Download Specific Medication as PDF
    public function downloadMedication($medicationId) {
        $patientId = Auth::guard('patient')->id() ?? Auth::id();

        // Check if patient is authenticated
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $patient = Auth::guard('patient')->user();

        // Fetch the specific medication
        $medication = Medication::where('id', $medicationId)
            ->where('patient_id', $patientId)
            ->firstOrFail();

        // Process medication for display
        $processedMedication = [
            'medication_name' => $medication->medication_name,
            'dosage' => $medication->formatted_dosage,
            'frequency' => $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified',
            'status' => $medication->status ?? 'Not specified',
            'start_date' => $medication->start_date 
                ? Carbon::parse($medication->start_date)->format('M d, Y') 
                : 'Not scheduled',
            'end_date' => $medication->end_date 
                ? Carbon::parse($medication->end_date)->format('M d, Y') 
                : 'No end date',
            'reason_for_med' => $medication->reason_for_med ?? 'Not specified',
            'notes' => $medication->notes ?? 'No additional notes',
            'created_at' => $medication->created_at ? $medication->created_at->format('M d, Y') : 'N/A',
            'updated_at' => $medication->updated_at ? $medication->updated_at->format('M d, Y') : 'N/A',
        ];

        return view('patient.modules.medication.download', [
            'patient' => $patient,
            'medication' => $processedMedication,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'fileName' => 'Medication_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
