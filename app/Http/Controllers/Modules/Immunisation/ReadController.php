<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReadController extends Controller
{
    /**
     * Show Immunisation Main Page
     */
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Immunisation model to find all records for this patient
        $immunisations = Immunisation::where('patient_id', $patientId)->get();

        // Process each immunisation with styling data
        $processedImmunisations = $immunisations->map(function ($immunisation) {
            return [
                'data' => $immunisation,
                'lastUpdated' => $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at,
                'lastUpdatedLabel' => ($immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at) 
                    ? Carbon::parse($immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at)->diffForHumans() 
                    : 'No recent updates',
                'vaccinationLabel' => $immunisation->vaccination_date 
                    ? Carbon::parse($immunisation->vaccination_date)->format('M d, Y') 
                    : 'Not recorded',
            ];
        });

        // Process timeline immunisations (top 5 most recent)
        $timelineImmunisations = $immunisations->sortByDesc(function ($immunisation) {
            return $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
        })->take(5)->map(function ($immunisation) {
            $timelineDate = $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
            
            return [
                'data' => $immunisation,
                'dateLabel' => $timelineDate 
                    ? Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalImmunisations = $immunisations->count();
        $thisYearImmunisations = $immunisations->filter(function ($immunisation) {
            return $immunisation->vaccination_date && 
                   Carbon::parse($immunisation->vaccination_date)->isCurrentYear();
        })->count();

        // Get last updated immunisation
        $lastUpdatedImmunisation = $immunisations->sortByDesc(function ($immunisation) {
            return $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedImmunisation 
            ? ($lastUpdatedImmunisation->updated_at ?? $lastUpdatedImmunisation->vaccination_date ?? $lastUpdatedImmunisation->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        // Common vaccine options for the select dropdown
        $vaccineOptions = [
            'COVID-19 (Pfizer-BioNTech)',
            'COVID-19 (Moderna)',
            'COVID-19 (AstraZeneca)',
            'COVID-19 (Sinovac)',
            'Influenza (Flu)',
            'Hepatitis B',
            'Hepatitis A',
            'BCG (Tuberculosis)',
            'DTP (Diphtheria, Tetanus, Pertussis)',
            'MMR (Measles, Mumps, Rubella)',
            'Polio (IPV/OPV)',
            'HPV (Human Papillomavirus)',
            'Varicella (Chickenpox)',
            'Pneumococcal',
            'Meningococcal',
            'Japanese Encephalitis',
            'Rabies',
            'Typhoid',
            'Yellow Fever'
        ];

        return view('patient.modules.immunisation.immunisation', [
            'immunisations' => $processedImmunisations,
            'timelineImmunisations' => $timelineImmunisations,
            'totalImmunisations' => $totalImmunisations,
            'thisYearImmunisations' => $thisYearImmunisations,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'vaccineOptions' => $vaccineOptions,
        ]);
    }

    /**
     * Download a specific immunisation record as PDF
     */
    public function downloadImmunisation(Immunisation $immunisation)
    {
        // Policy/Gate check: Ensure this immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.immunisation')->with('error', 'Unauthorized access to immunisation.');
        }

        $patient = Auth::guard('patient')->user();

        return view('patient.modules.immunisation.download', [
            'patient' => $patient,
            'immunisation' => $immunisation,
            'exportDate' => Carbon::now()->format('F d, Y'),
        ]);
    }

    /**
     * Get a specific immunisation as JSON for the edit modal.
     */
    public function getImmunisationJson(Immunisation $immunisation)
    {
        // Policy/Gate check: Ensure this immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the immunisation data
        return response()->json([
            'immunisation' => $immunisation
        ]);
    }

    /**
     * Show details of a specific immunisation
     */
    public function show(Immunisation $immunisation) {
        // Policy/Gate check: Ensure this immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.immunisation')->with('error', 'Unauthorized access to immunisation.');
        }

        // Process styling data for the immunisation
        $verificationBadgeStyles = match ($immunisation->verification_status) {
            'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $vaccinationLabel = $immunisation->vaccination_date 
            ? Carbon::parse($immunisation->vaccination_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $immunisation->created_at 
            ? Carbon::parse($immunisation->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $immunisation->updated_at 
            ? Carbon::parse($immunisation->updated_at)->diffForHumans() 
            : 'Never';

        return view('patient.modules.immunisation.moreInfo', [
            'immunisation' => $immunisation,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'vaccinationLabel' => $vaccinationLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }

    /**
     * Export all immunisations as PDF
     */
    public function exportPdf() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Get patient information
        $patient = Auth::guard('patient')->user();

        // Get all immunisations for this patient
        $immunisations = Immunisation::where('patient_id', $patientId)->get();

        // Process immunisations for display
        $processedImmunisations = $immunisations->map(function ($immunisation) {
            return [
                'vaccine_name' => $immunisation->vaccine_name,
                'dose_details' => $immunisation->dose_details ?? 'Not specified',
                'vaccination_date' => $immunisation->vaccination_date 
                    ? Carbon::parse($immunisation->vaccination_date)->format('M d, Y') : 'Not recorded',
                'administered_by' => $immunisation->administered_by ?? 'Not specified',
                'vaccine_lot_number' => $immunisation->vaccine_lot_number ?? 'Not specified',
                'notes' => $immunisation->notes ?? 'No additional notes',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.immunisation.exportPdf', [
            'patient' => $patient,
            'immunisations' => $processedImmunisations,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalImmunisations' => $immunisations->count(),
            'fileName' => 'Immunisations_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
