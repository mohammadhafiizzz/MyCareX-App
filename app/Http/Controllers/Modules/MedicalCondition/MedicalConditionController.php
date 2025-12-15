<?php

namespace App\Http\Controllers\Modules\medicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class MedicalConditionController extends Controller
{
    // Show Medical Condition Main Page
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Condition model to find all records for this patient
        // Sort by updated_at DESC to show most recently edited/updated records first
        // This ensures that any record with recent activity appears at the top
        $conditions = Condition::where('patient_id', $patientId)
            ->orderByRaw('updated_at DESC, created_at DESC')
            ->get();

        // Process each condition with styling data
        $processedConditions = $conditions->map(function ($condition) {
            return [
                'data' => $condition,
                'severityBorderClass' => match ($condition->severity) {
                    'Severe' => 'bg-red-500',
                    'Moderate' => 'bg-amber-500',
                    'Mild' => 'bg-green-500',
                    default => 'bg-gray-300',
                },
                'severityIconWrapper' => match ($condition->severity) {
                    'Severe' => 'bg-red-100 text-red-600',
                    'Moderate' => 'bg-amber-100 text-amber-600',
                    'Mild' => 'bg-green-100 text-green-600',
                    default => 'bg-gray-100 text-gray-500',
                },
                'severityBadgeStyles' => match ($condition->severity) {
                    'Severe' => 'bg-red-50 text-red-700 border border-red-200',
                    'Moderate' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Mild' => 'bg-green-50 text-green-700 border border-green-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'severityBadgeIcon' => match ($condition->severity) {
                    'Severe' => 'fas fa-exclamation-triangle',
                    'Moderate' => 'fas fa-info-circle',
                    'Mild' => 'fas fa-heart-circle-check',
                    default => 'fas fa-circle',
                },
                'statusBadgeStyles' => match ($condition->status) {
                    'Active' => 'bg-red-100 text-red-700 border border-red-200',
                    'Chronic' => 'bg-amber-100 text-amber-700 border border-amber-200',
                    'Resolved' => 'bg-green-100 text-green-700 border border-green-200',
                    default => 'bg-gray-100 text-gray-600 border border-gray-200',
                },
                'statusIcon' => match ($condition->status) {
                    'Active' => 'fas fa-circle-dot',
                    'Chronic' => 'fas fa-clock',
                    'Resolved' => 'fas fa-check-circle',
                    default => 'fas fa-circle',
                },
                'lastUpdated' => $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at,
                'lastUpdatedLabel' => ($condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at) 
                    ? \Illuminate\Support\Carbon::parse($condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at)->diffForHumans() 
                    : 'No recent updates',
                'diagnosisLabel' => $condition->diagnosis_date 
                    ? \Illuminate\Support\Carbon::parse($condition->diagnosis_date)->format('M d, Y') 
                    : 'Not recorded',
                'severityData' => \Illuminate\Support\Str::lower($condition->severity ?? 'unknown'),
                'statusData' => \Illuminate\Support\Str::lower($condition->status ?? 'unknown'),
            ];
        });

        // Process timeline conditions (top 6 most recent)
        $timelineConditions = $conditions->sortByDesc(function ($condition) {
            return $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
        })->take(6)->map(function ($condition) {
            $timelineDate = $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
            
            return [
                'data' => $condition,
                'severityBorder' => match ($condition->severity) {
                    'Severe' => 'bg-red-500',
                    'Moderate' => 'bg-amber-500',
                    'Mild' => 'bg-green-500',
                    default => 'bg-gray-300',
                },
                'severityIcon' => match ($condition->severity) {
                    'Severe' => 'text-red-600',
                    'Moderate' => 'text-amber-600',
                    'Mild' => 'text-green-600',
                    default => 'text-gray-500',
                },
                'statusBadge' => match ($condition->status) {
                    'Active' => 'bg-red-50 text-red-700 border border-red-200',
                    'Chronic' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'Resolved' => 'bg-green-50 text-green-700 border border-green-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'dateLabel' => $timelineDate 
                    ? \Illuminate\Support\Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalConditions = $conditions->count();
        $severeConditions = $conditions->where('severity', 'Severe')->count();
        $activeConditions = $conditions->whereIn('status', ['Active', 'Chronic'])->count();
        $resolvedConditions = $conditions->where('status', 'Resolved')->count();

        // Get last updated condition
        $lastUpdatedCondition = $conditions->sortByDesc(function ($condition) {
            return $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedCondition 
            ? ($lastUpdatedCondition->updated_at ?? $lastUpdatedCondition->diagnosis_date ?? $lastUpdatedCondition->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? \Illuminate\Support\Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        // Filter options
        $severityOptions = ['All', 'Severe', 'Moderate', 'Mild'];
        $statusOptions = ['All', 'Active', 'Chronic', 'Resolved'];
        
        // Filter color mappings
        $severityFilterColors = [
            'Severe' => 'text-red-500',
            'Moderate' => 'text-amber-500',
            'Mild' => 'text-green-500',
            'All' => 'text-blue-500',
        ];
        
        $statusFilterIcons = [
            'Active' => 'fa-circle-dot text-red-500',
            'Chronic' => 'fa-clock text-amber-500',
            'Resolved' => 'fa-check-circle text-green-500',
            'All' => 'fa-layer-group text-blue-500',
        ];

        return view('patient.modules.medicalCondition.medicalCondition', [
            'conditions' => $processedConditions,
            'timelineConditions' => $timelineConditions,
            'totalConditions' => $totalConditions,
            'severeConditions' => $severeConditions,
            'activeConditions' => $activeConditions,
            'resolvedConditions' => $resolvedConditions,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'severityOptions' => $severityOptions,
            'statusOptions' => $statusOptions,
            'severityFilterColors' => $severityFilterColors,
            'statusFilterIcons' => $statusFilterIcons,
        ]);
    }

    /**
     * Get a specific condition as JSON for the edit modal.
     */
    public function getConditionJson(Condition $condition)
    {
        // Policy/Gate check: Ensure this condition belongs to the authenticated patient
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the condition data
        return response()->json([
            'condition' => $condition
        ]);
    }

    /**
     * Show details of a specific medical condition
     */
    public function moreInfo(Condition $condition) {
        // Policy/Gate check: Ensure this condition belongs to the authenticated patient
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.medicalCondition')->with('error', 'Unauthorized access to medical condition.');
        }

        // Process styling data for the condition
        $severityBadgeStyles = match ($condition->severity) {
            'Severe' => 'bg-red-50 text-red-700 border border-red-200',
            'Moderate' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'Mild' => 'bg-green-50 text-green-700 border border-green-200',
            default => 'bg-gray-50 text-gray-600 border border-gray-200',
        };

        $severityBadgeIcon = match ($condition->severity) {
            'Severe' => 'fas fa-exclamation-triangle',
            'Moderate' => 'fas fa-info-circle',
            'Mild' => 'fas fa-heart-circle-check',
            default => 'fas fa-circle',
        };

        $statusBadgeStyles = match ($condition->status) {
            'Active' => 'bg-red-100 text-red-700 border border-red-200',
            'Chronic' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'Resolved' => 'bg-green-100 text-green-700 border border-green-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $diagnosisLabel = $condition->diagnosis_date 
            ? \Illuminate\Support\Carbon::parse($condition->diagnosis_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $condition->created_at 
            ? \Illuminate\Support\Carbon::parse($condition->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $condition->updated_at 
            ? \Illuminate\Support\Carbon::parse($condition->updated_at)->diffForHumans() 
            : 'Never';

        return view('patient.modules.medicalCondition.moreInfo', [
            'condition' => $condition,
            'severityBadgeStyles' => $severityBadgeStyles,
            'severityBadgeIcon' => $severityBadgeIcon,
            'statusBadgeStyles' => $statusBadgeStyles,
            'diagnosisLabel' => $diagnosisLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }
}