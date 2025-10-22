<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class DeleteConditionController extends Controller
{
    /**
     * Delete an existing medical condition.
     */
    public function delete(Condition $condition)
    {
        // Check if the authenticated patient owns this condition
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $condition->delete();

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('message', 'Medical condition deleted successfully.');
    }
}