<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;

class MedicationController extends Controller
{
    // Show medication page
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        
        // Get conditions for the navigation component
        $conditions = Condition::where('patient_id', $patientId)->get();

        // Get medications for the patient for the dashboard
        $medications = Medication::where('patient_id', $patientId)
            ->orderByDesc('updated_at')
            ->orderByDesc('start_date')
            ->get();

        // Calculate statistics
        $today = \Illuminate\Support\Carbon::today();
        $totalMedications = $medications->count();
        $activeMedications = $medications->where('status', 'Active')->count();
        $dailyMedications = $medications->filter(function ($med) {
            $frequency = strtolower($med->frequency ?? '');
            return \Illuminate\Support\Str::contains($frequency, 'day');
        })->count();

        // Get last updated medication
        $lastUpdatedMedication = $medications->sortByDesc(function ($med) {
            return $med->updated_at ?? $med->start_date ?? $med->created_at;
        })->first();
        $lastUpdatedLabel = $lastUpdatedMedication 
            ? \Illuminate\Support\Carbon::parse($lastUpdatedMedication->updated_at ?? $lastUpdatedMedication->start_date ?? $lastUpdatedMedication->created_at)->format('M d, Y') 
            : 'Not recorded';

        // Filter options - static status options always available
        $statusOptions = ['All', 'Active', 'On Hold', 'Completed', 'Discontinued'];

        // Filter styling mappings
        $statusFilterStyles = [
            'Active' => 'fa-circle-dot text-emerald-500',
            'On Hold' => 'fa-pause-circle text-amber-500',
            'Completed' => 'fa-check-circle text-blue-500',
            'Discontinued' => 'fa-ban text-red-500',
            'All' => 'fa-layer-group text-gray-500'
        ];

        // Process each medication with styling data
        $processedMedications = $medications->map(function ($medication) {
            $status = $medication->status ?? 'Not set';
            $lastUpdated = $medication->updated_at ?? $medication->start_date ?? $medication->created_at;

            return [
                'data' => $medication,
                'statusBadgeStyles' => match ($status) {
                    'Active' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
                    'On Hold' => 'bg-amber-100 text-amber-700 border border-amber-200',
                    'Completed' => 'bg-blue-100 text-blue-700 border border-blue-200',
                    'Discontinued' => 'bg-red-100 text-red-700 border border-red-200',
                    default => 'bg-gray-100 text-gray-600 border border-gray-200',
                },
                'statusIcon' => match ($status) {
                    'Active' => 'fas fa-circle-dot',
                    'On Hold' => 'fas fa-pause-circle',
                    'Completed' => 'fas fa-check-circle',
                    'Discontinued' => 'fas fa-ban',
                    default => 'fas fa-circle',
                },
                'frequency' => $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified',
                'dosage' => $medication->formatted_dosage, // Uses accessor to format as "X mg"
                'notes' => $medication->notes ?? 'No notes added yet.',
                'startDateLabel' => $medication->start_date ? $medication->start_date->format('M d, Y') : 'Not scheduled',
                'endDateLabel' => $medication->end_date ? $medication->end_date->format('M d, Y') : 'No end date',
                'lastUpdatedLabel' => $lastUpdated ? \Illuminate\Support\Carbon::parse($lastUpdated)->diffForHumans() : 'No recent updates',
                'dataStatus' => \Illuminate\Support\Str::slug(strtolower($status)),
                'dataFrequency' => \Illuminate\Support\Str::slug(strtolower($medication->frequency ?? 'unknown')),
            ];
        });

        // Process timeline medications (top 6 most recent)
        $timelineMedications = $medications->sortByDesc(function ($med) {
            return $med->updated_at ?? $med->start_date ?? $med->created_at;
        })->take(6)->map(function ($medication) {
            $status = $medication->status ?? 'Not set';
            $timelineDate = $medication->updated_at ?? $medication->start_date ?? $medication->created_at;

            return [
                'data' => $medication,
                'statusBadge' => match ($status) {
                    'Active' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                    'On Hold' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Completed' => 'bg-blue-50 text-blue-700 border border-blue-200',
                    'Discontinued' => 'bg-red-50 text-red-700 border border-red-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'dateLabel' => $timelineDate ? \Illuminate\Support\Carbon::parse($timelineDate)->format('M d, Y') : 'Date unavailable',
                'frequency' => $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified',
            ];
        });
        
        return view('patient.modules.medication.medication', [
            'conditions' => $conditions,
            'medications' => $processedMedications,
            'timelineMedications' => $timelineMedications,
            'totalMedications' => $totalMedications,
            'activeMedications' => $activeMedications,
            'dailyMedications' => $dailyMedications,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'statusOptions' => $statusOptions,
            'statusFilterStyles' => $statusFilterStyles,
        ]);
    }

    /**
     * Show details of a specific medication
     */
    public function moreInfo(Medication $medication) {
        // Policy/Gate check: Ensure this medication belongs to the authenticated patient
        if ($medication->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.medication')->with('error', 'Unauthorized access to medication.');
        }

        // Process styling data for the medication
        $status = $medication->status ?? 'Not set';

        $statusBadgeStyles = match ($status) {
            'Active' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'On Hold' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'Completed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Discontinued' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $statusIcon = match ($status) {
            'Active' => 'fas fa-circle-dot',
            'On Hold' => 'fas fa-pause-circle',
            'Completed' => 'fas fa-check-circle',
            'Discontinued' => 'fas fa-ban',
            default => 'fas fa-circle',
        };

        $frequency = $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified';
        $dosage = $medication->formatted_dosage; // Uses accessor to format as "X mg"
        $startDateLabel = $medication->start_date ? $medication->start_date->format('F d, Y') : 'Not scheduled';
        $endDateLabel = $medication->end_date ? $medication->end_date->format('F d, Y') : 'No end date';
        $createdLabel = $medication->created_at ? $medication->created_at->format('F d, Y') : 'Unknown';
        $updatedLabel = $medication->updated_at ? $medication->updated_at->diffForHumans() : 'Never';

        return view('patient.modules.medication.moreInfo', [
            'medication' => $medication,
            'statusBadgeStyles' => $statusBadgeStyles,
            'statusIcon' => $statusIcon,
            'frequency' => $frequency,
            'dosage' => $dosage,
            'startDateLabel' => $startDateLabel,
            'endDateLabel' => $endDateLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }

    // Get medication data as JSON for edit form
    public function getJson(Medication $medication) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        
        // Verify the medication belongs to the authenticated patient
        if ($medication->patient_id !== $patientId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'medication' => $medication
        ]);
    }
}