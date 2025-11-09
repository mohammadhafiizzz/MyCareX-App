<?php

namespace App\Http\Controllers\Modules\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LabTestController extends Controller
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
                'verificationBadgeStyles' => match ($labTest->verification_status) {
                    'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
                    'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
                    'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
                    default => 'bg-gray-100 text-gray-600 border border-gray-200',
                },
                'verificationIcon' => match ($labTest->verification_status) {
                    'Provider Confirmed' => 'fas fa-user-doctor',
                    'Patient Reported' => 'fas fa-user',
                    'Unverified' => 'fas fa-circle-question',
                    default => 'fas fa-circle',
                },
                'lastUpdated' => $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at,
                'lastUpdatedLabel' => ($labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at) 
                    ? \Illuminate\Support\Carbon::parse($labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at)->diffForHumans() 
                    : 'No recent updates',
                'testLabel' => $labTest->test_date 
                    ? \Illuminate\Support\Carbon::parse($labTest->test_date)->format('M d, Y') 
                    : 'Not recorded',
                'verificationData' => \Illuminate\Support\Str::lower($labTest->verification_status ?? 'unknown'),
            ];
        });

        // Process timeline lab tests (top 6 most recent)
        $timelineLabTests = $labTests->sortByDesc(function ($labTest) {
            return $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
        })->take(6)->map(function ($labTest) {
            $timelineDate = $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
            
            return [
                'data' => $labTest,
                'verificationBorder' => match ($labTest->verification_status) {
                    'Provider Confirmed' => 'bg-blue-600',
                    'Patient Reported' => 'bg-purple-600',
                    'Unverified' => 'bg-gray-400',
                    default => 'bg-gray-300',
                },
                'verificationIcon' => match ($labTest->verification_status) {
                    'Provider Confirmed' => 'text-blue-700',
                    'Patient Reported' => 'text-purple-700',
                    'Unverified' => 'text-gray-600',
                    default => 'text-gray-500',
                },
                'verificationBadge' => match ($labTest->verification_status) {
                    'Provider Confirmed' => 'bg-blue-50 text-blue-700 border border-blue-200',
                    'Patient Reported' => 'bg-purple-50 text-purple-700 border border-purple-200',
                    'Unverified' => 'bg-gray-50 text-gray-700 border border-gray-200',
                    default => 'bg-gray-50 text-gray-600 border border-gray-200',
                },
                'dateLabel' => $timelineDate 
                    ? \Illuminate\Support\Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalLabTests = $labTests->count();
        $confirmedLabTests = $labTests->where('verification_status', 'Provider Confirmed')->count();
        $thisYearLabTests = $labTests->filter(function ($labTest) {
            return $labTest->test_date && 
                   \Illuminate\Support\Carbon::parse($labTest->test_date)->isCurrentYear();
        })->count();

        // Get last updated lab test
        $lastUpdatedLabTest = $labTests->sortByDesc(function ($labTest) {
            return $labTest->updated_at ?? $labTest->test_date ?? $labTest->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedLabTest 
            ? ($lastUpdatedLabTest->updated_at ?? $lastUpdatedLabTest->test_date ?? $lastUpdatedLabTest->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? \Illuminate\Support\Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        // Filter options
        $verificationOptions = ['All', 'Provider Confirmed', 'Patient Reported', 'Unverified'];
        
        // Filter icon mappings
        $verificationFilterIcons = [
            'Provider Confirmed' => 'fa-user-doctor text-blue-500',
            'Patient Reported' => 'fa-user text-purple-500',
            'Unverified' => 'fa-circle-question text-gray-500',
            'All' => 'fa-layer-group text-blue-500',
        ];

        return view('patient.modules.lab.labTest', [
            'labTests' => $processedLabTests,
            'timelineLabTests' => $timelineLabTests,
            'totalLabTests' => $totalLabTests,
            'confirmedLabTests' => $confirmedLabTests,
            'thisYearLabTests' => $thisYearLabTests,
            'lastUpdatedLabel' => $lastUpdatedLabel,
            'verificationOptions' => $verificationOptions,
            'verificationFilterIcons' => $verificationFilterIcons,
        ]);
    }

    /**
     * Get a specific lab test as JSON for the edit modal.
     */
    public function getLabTestJson(Lab $labTest)
    {
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

        // Process styling data for the lab test
        $verificationBadgeStyles = match ($labTest->verification_status) {
            'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $verificationIcon = match ($labTest->verification_status) {
            'Provider Confirmed' => 'fas fa-user-doctor',
            'Patient Reported' => 'fas fa-user',
            'Unverified' => 'fas fa-circle-question',
            default => 'fas fa-circle',
        };

        $testLabel = $labTest->test_date 
            ? \Illuminate\Support\Carbon::parse($labTest->test_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $labTest->created_at 
            ? \Illuminate\Support\Carbon::parse($labTest->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $labTest->updated_at 
            ? \Illuminate\Support\Carbon::parse($labTest->updated_at)->diffForHumans() 
            : 'Never';

        return view('patient.modules.lab.moreInfo', [
            'labTest' => $labTest,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'verificationIcon' => $verificationIcon,
            'testLabel' => $testLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }

    /**
     * Store a newly created lab test.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'test_name' => 'required|string|max:150',
            'test_date' => 'required|date',
            'test_category' => 'required|string|max:100',
            'facility_name' => 'nullable|string|max:255',
            'verification_status' => 'required|in:Unverified,Provider Confirmed,Patient Reported',
            'file_attachment' => 'required|file|mimes:pdf|max:10240', // REQUIRED attachment, PDF only, max 10MB
            'notes' => 'nullable|string',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Handle REQUIRED file attachment upload BEFORE creating record
        try {
            $file = $request->file('file_attachment');

            // Target directory in public path
            $destinationPath = public_path('files/lab');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Generate temporary filename using timestamp
            $timestamp = time();
            $baseName = 'LabTest_temp_' . $timestamp . '_' . $patientId;
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $tempFilename = $baseName . '.' . $extension;

            // Move file into public/files/lab with temporary name
            $file->move($destinationPath, $tempFilename);

            // Build the public URL to store in DB
            $publicUrl = asset('files/lab/' . $tempFilename);

            // Add file URL to validated data
            $validatedData['file_attachment_url'] = $publicUrl;
            $validatedData['patient_id'] = $patientId;

            // Create new lab test record with file URL
            $labTest = Lab::create($validatedData);

            // Rename file to include the actual lab test ID
            $finalBaseName = 'LabTest_' . $labTest->id . '_Attachment';
            $finalFilename = $finalBaseName . '.' . $extension;
            $oldPath = public_path('files/lab/' . $tempFilename);
            $newPath = public_path('files/lab/' . $finalFilename);

            if (File::exists($oldPath)) {
                File::move($oldPath, $newPath);
                
                // Update the lab test with the final file URL
                $labTest->file_attachment_url = asset('files/lab/' . $finalFilename);
                $labTest->save();
            }

        } catch (\Exception $e) {
            // If file upload fails, return error
            return redirect()->back()->with('error', 'Failed to upload lab test attachment. Please try again.');
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Lab test added successfully');
    }

    /**
     * Update an existing lab test.
     */
    public function update(Request $request, Lab $labTest)
    {
        // Check if the authenticated patient owns this lab test
        if ($labTest->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'test_name' => 'required|string|max:150',
            'test_date' => 'required|date',
            'test_category' => 'required|string|max:100',
            'facility_name' => 'nullable|string|max:255',
            'verification_status' => 'required|in:Unverified,Provider Confirmed,Patient Reported',
            'notes' => 'nullable|string',
        ]);

        // Use the Model to update the record
        $labTest->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Lab test updated successfully.');
    }

    /**
     * Delete an existing lab test.
     */
    public function destroy(Lab $labTest)
    {
        // Check if the authenticated patient owns this lab test
        if ($labTest->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $labTest->delete();

        // Redirect to lab tests page with a success message
        return redirect()->route('patient.lab')->with('message', 'Lab test deleted successfully.');
    }

    /**
     * Upload file attachment for a lab test
     */
    public function uploadAttachment(Request $request, Lab $labTest)
    {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the lab test belongs to the authenticated patient
        if ($labTest->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Validate the uploaded file
        $request->validate([
            'file_attachment' => 'required|file|mimes:pdf|max:10240', // Max 10MB, PDF only
        ]);

        try {
            $file = $request->file('file_attachment');

            // Target directory in public path
            $destinationPath = public_path('files/lab');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Build filename: LabTest_{LAB_ID}_Attachment.pdf
            $labTestId = $labTest->id;
            $baseName = 'LabTest_' . $labTestId . '_Attachment';
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = $baseName . '.' . $extension;

            // Move file into public/files/lab
            $file->move($destinationPath, $filename);

            // Build the public URL to store in DB
            $publicUrl = asset('files/lab/' . $filename);

            // Update the lab test with file attachment URL
            $labTest->file_attachment_url = $publicUrl;
            $labTest->save();

            return redirect()
                ->back()
                ->with('success', 'Lab test attachment uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload attachment. Please try again.');
        }
    }
}
