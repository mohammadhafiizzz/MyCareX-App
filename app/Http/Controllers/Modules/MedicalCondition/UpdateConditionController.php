<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class UpdateConditionController extends Controller
{
    /**
     * Update an existing medical condition.
     */
    public function update(Request $request, Condition $condition)
    {
        // Check if the authenticated patient owns this condition
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'condition_name' => 'required|string|max:255',
            'diagnosis_date' => 'nullable|date',
            'description' => 'nullable|string',
            'severity' => 'required|in:Mild,Moderate,Severe',
            'status' => 'required|in:Active,Resolved,Chronic',
        ]);

        // Use the Model to update the record
        $condition->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('message', 'Medical condition updated successfully.');
    }
}