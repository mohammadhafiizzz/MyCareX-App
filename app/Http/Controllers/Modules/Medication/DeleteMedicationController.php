<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DeleteMedicationController extends Controller
{
    /**
     * Delete an existing medication.
     */
    public function delete(Medication $medication)
    {
        // Check if the authenticated patient owns this medication
        if ($medication->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated medication image if exists
        if ($medication->med_image_url) {
            $filename = basename($medication->med_image_url);
            $filePath = public_path('images/medication/' . $filename);
            
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        // Delete the medication record
        $medication->delete();

        // Redirect to medications page with a success message
        return redirect()->route('patient.medication')->with('success', 'Medication deleted successfully.');
    }
}
