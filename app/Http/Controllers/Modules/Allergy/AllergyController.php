<?php

namespace App\Http\Controllers\Modules\Allergy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allergy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AllergyController extends Controller
{
    // Show Allergy Main Page
    public function index() {
        
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Allergy model to find all records for this patient
        $allergies = Allergy::where('patient_id', $patientId)->get();

        // Process each allergy with styling data
        $processedAllergies = $allergies->map(function ($allergy) {
            return [
                'data' => $allergy,
                'severityBadgeStyles' => match ($allergy->severity) {
                    'Life-threatening' => 'bg-red-100 text-red-800 border border-red-300',
                    'Severe' => 'bg-red-50 text-red-700 border border-red-200',
                    'Moderate' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Mild' => 'bg-green-50 text-green-700 border border-green-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'severityBadgeIcon' => match ($allergy->severity) {
                    'Life-threatening' => 'fas fa-skull-crossbones',
                    'Severe' => 'fas fa-exclamation-triangle',
                    'Moderate' => 'fas fa-info-circle',
                    'Mild' => 'fas fa-heart-circle-check',
                    default => 'fas fa-circle',
                },
                'statusBadgeStyles' => match ($allergy->status) {
                    'Active' => 'bg-red-100 text-red-700 border border-red-200',
                    'Suspected' => 'bg-amber-100 text-amber-700 border border-amber-200',
                    'Resolved' => 'bg-green-100 text-green-700 border border-green-200',
                    'Inactive' => 'bg-gray-100 text-gray-700 border border-gray-200',
                    default => 'bg-gray-100 text-gray-600 border border-gray-200',
                },
                'statusIcon' => match ($allergy->status) {
                    'Active' => 'fas fa-circle-dot',
                    'Suspected' => 'fas fa-question-circle',
                    'Resolved' => 'fas fa-check-circle',
                    'Inactive' => 'fas fa-circle-pause',
                    default => 'fas fa-circle',
                },
                'verificationBadgeStyles' => match ($allergy->verification_status) {
                    'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
                    'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
                    'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
                    default => 'bg-gray-100 text-gray-600 border border-gray-200',
                },
                'verificationIcon' => match ($allergy->verification_status) {
                    'Provider Confirmed' => 'fas fa-user-doctor',
                    'Patient Reported' => 'fas fa-user',
                    'Unverified' => 'fas fa-circle-question',
                    default => 'fas fa-circle',
                },
                'lastUpdated' => $allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at,
                'lastUpdatedLabel' => ($allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at) 
                    ? Carbon::parse($allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at)->diffForHumans() 
                    : 'No recent updates',
                'observedLabel' => $allergy->first_observed_date 
                    ? Carbon::parse($allergy->first_observed_date)->format('M d, Y') 
                    : 'Not recorded',
                'severityData' => Str::lower($allergy->severity ?? 'unknown'),
                'statusData' => Str::lower($allergy->status ?? 'unknown'),
            ];
        });

        // Process timeline allergies (top 6 most recent)
        $timelineAllergies = $allergies->sortByDesc(function ($allergy) {
            return $allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at;
        })->take(6)->map(function ($allergy) {
            $timelineDate = $allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at;
            
            return [
                'data' => $allergy,
                'severityBorder' => match ($allergy->severity) {
                    'Life-threatening' => 'bg-red-600',
                    'Severe' => 'bg-red-500',
                    'Moderate' => 'bg-amber-500',
                    'Mild' => 'bg-green-500',
                    default => 'bg-gray-300',
                },
                'severityIcon' => match ($allergy->severity) {
                    'Life-threatening' => 'text-red-700',
                    'Severe' => 'text-red-600',
                    'Moderate' => 'text-amber-600',
                    'Mild' => 'text-green-600',
                    default => 'text-gray-500',
                },
                'statusBadge' => match ($allergy->status) {
                    'Active' => 'bg-red-50 text-red-700 border border-red-200',
                    'Suspected' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Resolved' => 'bg-green-50 text-green-700 border border-green-200',
                    'Inactive' => 'bg-gray-50 text-gray-700 border border-gray-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'dateLabel' => $timelineDate 
                    ? Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalAllergies = $allergies->count();
        $severeAllergies = $allergies->whereIn('severity', ['Severe', 'Life-threatening'])->count();
        $activeAllergies = $allergies->where('status', 'Active')->count();
        $confirmedAllergies = $allergies->where('verification_status', 'Provider Confirmed')->count();

        // Get last updated allergy
        $lastUpdatedAllergy = $allergies->sortByDesc(function ($allergy) {
            return $allergy->updated_at ?? $allergy->first_observed_date ?? $allergy->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedAllergy 
            ? ($lastUpdatedAllergy->updated_at ?? $lastUpdatedAllergy->first_observed_date ?? $lastUpdatedAllergy->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        // Filter options
        $severityOptions = ['All', 'Life-threatening', 'Severe', 'Moderate', 'Mild'];
        $statusOptions = ['All', 'Active', 'Suspected', 'Resolved', 'Inactive'];
        
        // Filter color mappings
        $severityFilterColors = [
            'Life-threatening' => 'text-red-700',
            'Severe' => 'text-red-500',
            'Moderate' => 'text-amber-500',
            'Mild' => 'text-green-500',
            'All' => 'text-blue-500',
        ];
        
        $statusFilterIcons = [
            'Active' => 'fa-circle-dot text-red-500',
            'Suspected' => 'fa-question-circle text-amber-500',
            'Resolved' => 'fa-check-circle text-green-500',
            'Inactive' => 'fa-circle-pause text-gray-500',
            'All' => 'fa-layer-group text-blue-500',
        ];

        return view('patient.modules.allergy.allergy', [
            'allergies' => $processedAllergies,
            'timelineAllergies' => $timelineAllergies,
            'totalAllergies' => $totalAllergies,
            'severeAllergies' => $severeAllergies,
            'activeAllergies' => $activeAllergies,
            'confirmedAllergies' => $confirmedAllergies,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'severityOptions' => $severityOptions,
            'statusOptions' => $statusOptions,
            'severityFilterColors' => $severityFilterColors,
            'statusFilterIcons' => $statusFilterIcons,
        ]);
    }

    /**
     * Get a specific allergy as JSON for the edit modal.
     */
    public function getAllergyJson(Allergy $allergy)
    {
        // Policy/Gate check: Ensure this allergy belongs to the authenticated patient
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the allergy data
        return response()->json([
            'allergy' => $allergy
        ]);
    }

    /**
     * Show details of a specific allergy
     */
    public function show(Allergy $allergy) {
        // Policy/Gate check: Ensure this allergy belongs to the authenticated patient
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.allergy')->with('error', 'Unauthorized access to allergy.');
        }

        // Process styling data for the allergy
        $severityBadgeStyles = match ($allergy->severity) {
            'Life-threatening' => 'bg-red-100 text-red-800 border border-red-300',
            'Severe' => 'bg-red-50 text-red-700 border border-red-200',
            'Moderate' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'Mild' => 'bg-green-50 text-green-700 border border-green-200',
            default => 'bg-gray-50 text-gray-600 border border-gray-200',
        };

        $severityBadgeIcon = match ($allergy->severity) {
            'Life-threatening' => 'fas fa-skull-crossbones',
            'Severe' => 'fas fa-exclamation-triangle',
            'Moderate' => 'fas fa-info-circle',
            'Mild' => 'fas fa-heart-circle-check',
            default => 'fas fa-circle',
        };

        $statusBadgeStyles = match ($allergy->status) {
            'Active' => 'bg-red-100 text-red-700 border border-red-200',
            'Suspected' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'Resolved' => 'bg-green-100 text-green-700 border border-green-200',
            'Inactive' => 'bg-gray-100 text-gray-700 border border-gray-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $verificationBadgeStyles = match ($allergy->verification_status) {
            'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $verificationIcon = match ($allergy->verification_status) {
            'Provider Confirmed' => 'fas fa-user-doctor',
            'Patient Reported' => 'fas fa-user',
            'Unverified' => 'fas fa-circle-question',
            default => 'fas fa-circle',
        };

        $observedLabel = $allergy->first_observed_date 
            ? Carbon::parse($allergy->first_observed_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $allergy->created_at 
            ? Carbon::parse($allergy->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $allergy->updated_at 
            ? Carbon::parse($allergy->updated_at)->diffForHumans() 
            : 'Never';

        return view('patient.modules.allergy.moreInfo', [
            'allergy' => $allergy,
            'severityBadgeStyles' => $severityBadgeStyles,
            'severityBadgeIcon' => $severityBadgeIcon,
            'statusBadgeStyles' => $statusBadgeStyles,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'verificationIcon' => $verificationIcon,
            'observedLabel' => $observedLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }

    /**
     * Store a newly created allergy.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new allergy record
        Allergy::create($validatedData);

        // Return back with success message
        return redirect()->back()->with('message', 'Allergy added successfully');
    }

    /**
     * Update an existing allergy.
     */
    public function update(Request $request, Allergy $allergy)
    {
        // Check if the authenticated patient owns this allergy
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
        ]);

        // Use the Model to update the record
        $allergy->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Allergy updated successfully.');
    }

    /**
     * Delete an existing allergy.
     */
    public function destroy(Allergy $allergy)
    {
        // Check if the authenticated patient owns this allergy
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $allergy->delete();

        // Redirect to allergies page with a success message
        return redirect()->route('patient.allergy')->with('message', 'Allergy deleted successfully.');
    }

    /**
     * Export all allergies as PDF
     */
    public function exportPdf() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Get patient information
        $patient = Auth::guard('patient')->user();

        // Get all allergies for this patient
        $allergies = Allergy::where('patient_id', $patientId)->get();

        // Process allergies for display
        $processedAllergies = $allergies->map(function ($allergy) {
            return [
                'allergen' => $allergy->allergen,
                'allergy_type' => $allergy->allergy_type,
                'severity' => $allergy->severity ? Str::title($allergy->severity) : 'Not specified',
                'reaction_desc' => $allergy->reaction_desc ?? 'Not specified',
                'status' => $allergy->status ?? 'Not specified',
                'first_observed_date' => $allergy->first_observed_date 
                    ? Carbon::parse($allergy->first_observed_date)->format('M d, Y') 
                    : 'Not recorded',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.allergy.exportPdf', [
            'patient' => $patient,
            'allergies' => $processedAllergies,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalAllergies' => $allergies->count(),
            'fileName' => 'Allergies_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
