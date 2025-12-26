<?php

namespace App\Http\Controllers\Modules\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CreateController extends Controller
{
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
            'file_attachment' => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240', // REQUIRED attachment, PDF, PNG, JPG, and JPEG only, max 10MB
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
}
