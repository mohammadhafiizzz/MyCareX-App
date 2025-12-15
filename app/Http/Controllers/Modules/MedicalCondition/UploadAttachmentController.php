<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UploadAttachmentController extends Controller
{
    // Upload attachment for a medical condition
    public function upload(Request $request, Condition $condition) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the condition belongs to the authenticated patient
        if ($condition->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Validate the uploaded file
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240', // Max 10MB, PDF, PNG, JPG, JPEG
        ]);

        try {
            $file = $request->file('attachment');

            // Target directory in public path
            $destinationPath = public_path('files/medicalCondition');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Build filename: Condition_{CONDITION_ID}_Attachment.{ext}
            $conditionId = $condition->id;
            $baseName = 'Condition_' . $conditionId . '_Attachment';
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = $baseName . '.' . $extension;

            // Move file into public/images/medicalCondition
            $file->move($destinationPath, $filename);

            // Build the public URL to store in DB
            $publicUrl = asset('files/medicalCondition/' . $filename);

            // Update the condition with attachment URL
            $condition->doc_attachments_url = $publicUrl;
            $condition->save();

            return redirect()
                ->back()
                ->with('success', 'Attachment uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload attachment. Please try again.');
        }
    }

    // Delete attachment for a medical condition
    public function deleteAttachment(Request $request, Condition $condition) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the condition belongs to the authenticated patient
        if ($condition->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // Get the file path from the URL
            if ($condition->doc_attachments_url) {
                // Extract filename from URL
                $filename = basename($condition->doc_attachments_url);
                $filePath = public_path('files/medicalCondition/' . $filename);

                // Delete the file if it exists
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // Remove the URL from database
                $condition->doc_attachments_url = null;
                $condition->save();

                return redirect()
                    ->back()
                    ->with('success', 'Attachment deleted successfully.');
            }

            return redirect()
                ->back()
                ->with('error', 'No attachment found to delete.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete attachment. Please try again.');
        }
    }
}
