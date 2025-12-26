<?php

namespace App\Http\Controllers\Modules\Allergy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allergy;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    /**
     * Store a newly created allergy.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'allergen' => 'required|string|max:150',
            'allergy_type' => 'required|string|max:150',
            'severity' => 'required|in:Mild,Moderate,Severe,Life-threatening',
            'reaction_desc' => 'nullable|string',
            'status' => 'required|in:Active,Inactive,Resolved,Suspected',
            'first_observed_date' => 'required|date',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new allergy record
        Allergy::create($validatedData);

        // Return back with success message
        return redirect()->back()->with('message', 'Allergy added successfully');
    }
}
