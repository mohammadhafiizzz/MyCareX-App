<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UploadMedicationImageController extends Controller
{
    // Upload image for a medication
    public function upload(Request $request, Medication $medication) {
        
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }
        

        // Verify the medication belongs to the authenticated patient
        if ($medication->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Validate the uploaded file
        $validatedData = $request->validate([
            'med_image_url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('med_image_url');
                        
            if (!$file) {
                return redirect()->back()->with('error', 'No file uploaded.');
            }

            // Target directory in public path
            $destinationPath = public_path('files/medication');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Build filename: Medication_{MEDICATION_ID}_Image.{ext}
            $medicationId = $medication->id;
            $baseName = 'Medication_' . $medicationId . '_Image';
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = $baseName . '.' . $extension;
            
            // Delete old image if exists
            if ($medication->med_image_url) {
                $oldFilename = basename($medication->med_image_url);
                $oldFilePath = public_path('files/medication/' . $oldFilename);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Move file into public/images/medication
            $fileMoved = $file->move($destinationPath, $filename);
                        
            if (!$fileMoved) {
                return redirect()->back()->with('error', 'Failed to move file to destination.');
            }

            // Build the public URL to store in DB
            $publicUrl = asset('files/medication/' . $filename);

            // Update the medication with image URL using direct attribute assignment
            $medication->med_image_url = $publicUrl;
            
            $saved = $medication->save();
            
            if (!$saved) {
                return redirect()->back()->with('error', 'Failed to save image URL to database.');
            }

            return redirect()
                ->back()
                ->with('success', 'Medication image uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

    // Delete image for a medication
    public function deleteImage(Request $request, Medication $medication) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the medication belongs to the authenticated patient
        if ($medication->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // Get the file path from the URL
            if ($medication->med_image_url) {
                // Extract filename from URL
                $filename = basename($medication->med_image_url);
                $filePath = public_path('files/medication/' . $filename);

                // Delete the file if it exists
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // Remove the URL from database
                $medication->med_image_url = null;
                $medication->save();

                return redirect()
                    ->back()
                    ->with('success', 'Medication image deleted successfully.');
            }

            return redirect()
                ->back()
                ->with('error', 'No image found to delete.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete image. Please try again.');
        }
    }
}
