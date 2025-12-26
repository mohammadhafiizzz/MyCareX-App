<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    /**
     * Delete an existing immunisation.
     */
    public function destroy(Immunisation $immunisation)
    {
        // Check if the authenticated patient owns this immunisation
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $immunisation->delete();

        // Redirect to immunisations page with a success message
        return redirect()->route('patient.immunisation')->with('message', 'Vaccination deleted successfully.');
    }

    /**
     * Delete certificate for an immunisation
     */
    public function deleteCertificate(Request $request, Immunisation $immunisation)
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

        try {
            // Get the file path from the URL
            if ($immunisation->certificate_url) {
                // Extract filename from URL
                $filename = basename($immunisation->certificate_url);
                $filePath = public_path('files/vaccination/' . $filename);

                // Delete the file if it exists
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // Remove the URL from database
                $immunisation->certificate_url = null;
                $immunisation->save();

                return redirect()
                    ->back()
                    ->with('success', 'Vaccination certificate deleted successfully.');
            }

            return redirect()
                ->back()
                ->with('error', 'No certificate found to delete.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete certificate. Please try again.');
        }
    }
}
