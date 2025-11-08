<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;

class UpdateMedicationController extends Controller
{
    /**
     * Update an existing medication.
     */
    public function update(Request $request, Medication $medication)
    {
        // Check if the authenticated patient owns this medication
        if ($medication->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|integer|min:1|max:999999',
            'frequency' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'status' => 'required|in:Active,On Hold,Completed,Discontinued',
            'reason_for_med' => 'nullable|string',
        ]);

        // Update the medication record
        $medication->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Medication updated successfully.');
    }
}
