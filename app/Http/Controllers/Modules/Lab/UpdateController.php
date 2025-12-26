<?php

namespace App\Http\Controllers\Modules\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
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
            'notes' => 'nullable|string',
        ]);

        // Use the Model to update the record
        $labTest->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Lab test updated successfully.');
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
            'file_attachment' => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240', // Max 10MB, PDF and images only
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
