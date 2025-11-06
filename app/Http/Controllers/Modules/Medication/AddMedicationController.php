<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AddMedicationController extends Controller
{
    // Add new medication for a patient
    public function add(Request $request) {
        $validatedData = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Active,On Hold,Completed,Discontinued',
            'reason_for_med' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Only images, max 10MB
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new medication record
        $medication = Medication::create($validatedData);

        // Handle optional image upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');

                // Target directory in public path
                $destinationPath = public_path('images/medication');

                // Ensure directory exists
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Build filename: Medication_{MEDICATION_ID}_Image.{ext}
                $medicationId = $medication->id;
                $baseName = 'Medication_' . $medicationId . '_Image';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                // Move file into public/images/medication
                $file->move($destinationPath, $filename);

                // Build the public URL to store in DB
                $publicUrl = asset('images/medication/' . $filename);

                // Update the medication with image URL
                $medication->med_image = $publicUrl;
                $medication->save();
            } catch (\Exception $e) {
                // If file upload fails, still create the medication but notify user
                return redirect()->back()->with('warning', 'Medication added successfully, but image upload failed.');
            }
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Medication added successfully');
    }
}
