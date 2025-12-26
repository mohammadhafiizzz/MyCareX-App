<?php

namespace App\Http\Controllers\Modules\Lab;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
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
}
