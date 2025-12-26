<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CreateController extends Controller
{
    /**
     * Store a newly created immunisation.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'dose_details' => 'nullable|string|max:100',
            'vaccination_date' => 'required|date',
            'administered_by' => 'nullable|string|max:255',
            'vaccine_lot_number' => 'nullable|string|max:100',
            'certificate' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240', // Optional certificate, PDF, PNG, JPG, JPEG only, max 10MB
            'notes' => 'nullable|string',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new immunisation record
        $immunisation = Immunisation::create($validatedData);

        // Handle optional certificate upload
        if ($request->hasFile('certificate')) {
            try {
                $file = $request->file('certificate');

                // Target directory in public path
                $destinationPath = public_path('files/vaccination');

                // Ensure directory exists
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Build filename: Vaccination_{IMMUNISATION_ID}_Certificate.pdf
                $immunisationId = $immunisation->id;
                $baseName = 'Vaccination_' . $immunisationId . '_Certificate';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                // Move file into public/files/vaccination
                $file->move($destinationPath, $filename);

                // Build the public URL to store in DB
                $publicUrl = asset('files/vaccination/' . $filename);

                // Update the immunisation with certificate URL
                $immunisation->certificate_url = $publicUrl;
                $immunisation->save();
            } catch (\Exception $e) {
                // If file upload fails, still create the immunisation but notify user
                return redirect()->back()->with('warning', 'Vaccination added successfully, but certificate upload failed.');
            }
        }

        // Return back with success message
        return redirect()->back()->with('message', 'Vaccination added successfully');
    }
}
