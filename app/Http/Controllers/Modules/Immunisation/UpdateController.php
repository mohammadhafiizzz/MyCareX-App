<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    /**
     * Update an existing immunisation.
     */
    public function update(Request $request, Immunisation $immunisation)
    {
        // Check if the authenticated patient owns this immunisation
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'dose_details' => 'nullable|string|max:100',
            'vaccination_date' => 'required|date',
            'administered_by' => 'nullable|string|max:255',
            'vaccine_lot_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Use the Model to update the record
        $immunisation->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Vaccination updated successfully.');
    }

    /**
     * Upload certificate for an immunisation
     */
    public function uploadCertificate(Request $request, Immunisation $immunisation)
    {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Validate the uploaded file
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240', // Max 10MB, PDF, PNG, JPG, and JPEG only
        ]);

        try {
            $file = $request->file('certificate');

            // Target directory in public path
            $destinationPath = public_path('files/vaccination');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Build filename: Vaccination_{IMMUNISATION_ID}_Certificate.pdf
            $immunisationId = $immunisation->id;
            $baseName = 'Vaccination_' . $immunisationId . '_Certificate';
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = $baseName . '.' . $extension;

            // Move file into public/files/vaccination
            $file->move($destinationPath, $filename);

            // Build the public URL to store in DB
            $publicUrl = asset('files/vaccination/' . $filename);

            // Update the immunisation with certificate URL
            $immunisation->certificate_url = $publicUrl;
            $immunisation->save();

            return redirect()
                ->back()
                ->with('success', 'Vaccination certificate uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload certificate. Please try again.');
        }
    }
}
