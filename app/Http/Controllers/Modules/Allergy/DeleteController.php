<?php

namespace App\Http\Controllers\Modules\Allergy;

use App\Http\Controllers\Controller;
use App\Models\Allergy;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    /**
     * Delete an existing allergy.
     */
    public function destroy(Allergy $allergy)
    {
        // Check if the authenticated patient owns this allergy
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $allergy->delete();

        // Redirect to allergies page with a success message
        return redirect()->route('patient.allergy')->with('message', 'Allergy deleted successfully.');
    }
}
