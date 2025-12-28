<?php

namespace App\Http\Controllers\Modules\Lab;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReadController extends Controller
{
    /**
     * Show Lab Test Main Page
     */
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Lab model to find all records for this patient
        $labTests = Lab::where('patient_id', $patientId)->get();

        // Process each lab test with styling data
        $processedLabTests = $labTests->map(function ($labTest) {
            return [
                'data' => $labTest,
                'lastUpdated' => $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at,
                'lastUpdatedLabel' => ($labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at) 
                    ? Carbon::parse($labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at)->diffForHumans() 
                    : 'No recent updates',
                'testLabel' => $labTest->test_date 
                    ? Carbon::parse($labTest->test_date)->format('M d, Y') 
                    : 'Not recorded',
            ];
        });

        // Process timeline lab tests (top 5 most recent)
        $timelineLabTests = $labTests->sortByDesc(function ($labTest) {
            return $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
        })->take(5)->map(function ($labTest) {
            $timelineDate = $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
            
            return [
                'data' => $labTest,
                'dateLabel' => $timelineDate 
                    ? Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalLabTests = $labTests->count();
        $thisYearLabTests = $labTests->filter(function ($labTest) {
            return $labTest->test_date && 
                   Carbon::parse($labTest->test_date)->isCurrentYear();
        })->count();

        // Get last updated lab test
        $lastUpdatedLabTest = $labTests->sortByDesc(function ($labTest) {
            return $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedLabTest 
            ? ($lastUpdatedLabTest->updated_at ?? $lastUpdatedLabTest->test_date ?? $lastUpdatedLabTest->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        // Common lab test options for the select dropdown
        $labTestOptions = [
            'Complete Blood Count (CBC)',
            'Basic Metabolic Panel (BMP)',
            'Comprehensive Metabolic Panel (CMP)',
            'Lipid Panel (Cholesterol)',
            'Liver Function Test (LFT)',
            'Thyroid Stimulating Hormone (TSH)',
            'Hemoglobin A1c (HbA1c)',
            'Urinalysis',
            'Prostate-Specific Antigen (PSA)',
            'Vitamin D Test',
            'Iron / Ferritin Test',
            'Electrolyte Panel',
            'Blood Glucose Test',
            'C-Reactive Protein (CRP)',
            'Kidney Function Test (BUN/Creatinine)',
            'Coagulation Panel (PT/INR)',
            'Cardiac Biomarkers (Troponin)',
            'Allergy Testing (IgE)',
            'Infectious Disease Screening'
        ];

        // Lab test category options for select dropdown]
        $labTestCategoryOptions = [
            'Hematology',
            'Biochemistry',
            'Microbiology',
            'Immunology',
            'Molecular Diagnostics',
            'Cytology',
            'Pathology',
            'Urinalysis',
            'Blood Gas Analysis',
            'Toxicology',
            'Serology',
            'Coagulation Studies',
        ];

        return view('patient.modules.lab.labTest', [
            'labTests' => $processedLabTests,
            'timelineLabTests' => $timelineLabTests,
            'totalLabTests' => $totalLabTests,
            'thisYearLabTests' => $thisYearLabTests,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'labTestOptions' => $labTestOptions,
            'labTestCategoryOptions' => $labTestCategoryOptions,
        ]);
    }

    /**
     * Get a specific lab test as JSON for the edit modal.
     */
    public function getLabTestJson(Lab $labTest) {
        // Policy/Gate check: Ensure this lab test belongs to the authenticated patient
        if ($labTest->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the lab test data
        return response()->json([
            'labTest' => $labTest
        ]);
    }

    /**
     * Show details of a specific lab test
     */
    public function show(Lab $labTest) {
        // Policy/Gate check: Ensure this lab test belongs to the authenticated patient
        if ($labTest->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.lab')->with('error', 'Unauthorized access to lab test.');
        }

        $testLabel = $labTest->test_date 
            ? Carbon::parse($labTest->test_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $labTest->created_at 
            ? Carbon::parse($labTest->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $labTest->updated_at 
            ? Carbon::parse($labTest->updated_at)->diffForHumans() 
            : 'Never';

        // Common lab test options for the select dropdown
        $labTestOptions = [
            'Complete Blood Count (CBC)',
            'Basic Metabolic Panel (BMP)',
            'Comprehensive Metabolic Panel (CMP)',
            'Lipid Panel (Cholesterol)',
            'Liver Function Test (LFT)',
            'Thyroid Stimulating Hormone (TSH)',
            'Hemoglobin A1c (HbA1c)',
            'Urinalysis',
            'Prostate-Specific Antigen (PSA)',
            'Vitamin D Test',
            'Iron / Ferritin Test',
            'Electrolyte Panel',
            'Blood Glucose Test',
            'C-Reactive Protein (CRP)',
            'Kidney Function Test (BUN/Creatinine)',
            'Coagulation Panel (PT/INR)',
            'Cardiac Biomarkers (Troponin)',
            'Allergy Testing (IgE)',
            'Infectious Disease Screening'
        ];

        // Lab test category options for select dropdown]
        $labTestCategoryOptions = [
            'Hematology',
            'Biochemistry',
            'Microbiology',
            'Immunology',
            'Molecular Diagnostics',
            'Cytology',
            'Pathology',
            'Urinalysis',
            'Blood Gas Analysis',
            'Toxicology',
            'Serology',
            'Coagulation Studies',
        ];

        return view('patient.modules.lab.moreInfo', [
            'labTest' => $labTest,
            'testLabel' => $testLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
            'labTestOptions' => $labTestOptions,
            'labTestCategoryOptions' => $labTestCategoryOptions,
        ]);
    }

    /**
     * Export all lab tests as PDF
     */
    public function exportPdf() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Get patient information
        $patient = Auth::guard('patient')->user();

        // Get all lab tests for this patient
        $labTests = Lab::where('patient_id', $patientId)->get();

        // Process lab tests for display
        $processedLabTests = $labTests->map(function ($labTest) {
            return [
                'test_name' => $labTest->test_name,
                'test_date' => $labTest->test_date 
                    ? Carbon::parse($labTest->test_date)->format('M d, Y') : 'Not recorded',
                'test_category' => $labTest->test_category,
                'facility_name' => $labTest->facility_name ?? 'Not specified',
                'notes' => $labTest->notes ?? 'No additional notes',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.lab.exportPdf', [
            'patient' => $patient,
            'labTests' => $processedLabTests,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalLabTests' => $labTests->count(),
            'fileName' => 'LabTests_' . Carbon::now()->format('Y-m-d'),
        ]);
    }

    // Download Specific Lab Test as PDF
    public function downloadLab($labTestId) {
        $patientId = Auth::guard('patient')->id() ?? Auth::id();

        // Check if patient is authenticated
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $patient = Auth::guard('patient')->user();

        // Fetch the specific lab test
        $labTest = Lab::where('id', $labTestId)
            ->where('patient_id', $patientId)
            ->firstOrFail();

        // Process lab test for display
        $processedLabTest = [
            'test_name' => $labTest->test_name,
            'test_date' => $labTest->test_date ? Carbon::parse($labTest->test_date)->format('M d, Y') : 'Not recorded',
            'test_category' => $labTest->test_category ?? 'Not specified',
            'facility_name' => $labTest->facility_name ?? 'Not specified',
            'notes' => $labTest->notes ?? 'No additional notes',
            'created_at' => $labTest->created_at ? $labTest->created_at->format('M d, Y') : 'N/A',
            'updated_at' => $labTest->updated_at ? $labTest->updated_at->format('M d, Y') : 'N/A',
        ];

        return view('patient.modules.lab.download', [
            'patient' => $patient,
            'labTest' => $processedLabTest,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'fileName' => 'LabTest_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
