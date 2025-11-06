<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AddConditionController extends Controller
{
    // Add new medical condition for a patient
    public function add(Request $request) {
        $validatedData = $request->validate([
            'condition_name' => 'required|string|max:255',
            'diagnosis_date' => 'nullable|date',
            'description' => 'nullable|string',
            'severity' => 'required|in:Mild,Moderate,Severe',
            'status' => 'required|in:Active,Resolved,Chronic',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Optional attachment, max 10MB
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new condition record
        $condition = Condition::create($validatedData);

        // Handle optional file upload
        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');

                // Target directory in public path
                $destinationPath = public_path('files/medicalCondition');

                // Ensure directory exists
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Build filename: Condition_{CONDITION_ID}_Attachment.{ext}
                $conditionId = $condition->id;
                $baseName = 'Condition_' . $conditionId . '_Attachment';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                // Move file into public/files/medicalCondition
                $file->move($destinationPath, $filename);

                // Build the public URL to store in DB
                $publicUrl = asset('images/medicalCondition/' . $filename);

                // Update the condition with attachment URL
                $condition->doc_attachments_url = $publicUrl;
                $condition->save();
            } catch (\Exception $e) {
                // If file upload fails, still create the condition but notify user
                return redirect()->back()->with('warning', 'Medical condition added successfully, but attachment upload failed.');
            }
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Medical condition added successfully');
    }
}
