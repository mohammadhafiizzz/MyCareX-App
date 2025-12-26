<?php

namespace App\Http\Controllers\Modules\Allergy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allergy;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    /**
     * Update an existing allergy.
     */
    public function update(Request $request, Allergy $allergy)
    {
        // Check if the authenticated patient owns this allergy
        if ($allergy->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
        ]);

        // Use the Model to update the record
        $allergy->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Allergy updated successfully.');
    }
}
