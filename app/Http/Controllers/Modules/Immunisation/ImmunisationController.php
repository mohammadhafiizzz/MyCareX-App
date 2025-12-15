<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ImmunisationController extends Controller
{
    /**
     * Show Immunisation Main Page
     */
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Immunisation model to find all records for this patient
        $immunisations = Immunisation::where('patient_id', $patientId)->get();

        // Process each immunisation with styling data
        $processedImmunisations = $immunisations->map(function ($immunisation) {
            return [
                'data' => $immunisation,
                'lastUpdated' => $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at,
                'lastUpdatedLabel' => ($immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at) 
                    ? Carbon::parse($immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at)->diffForHumans() 
                    : 'No recent updates',
                'vaccinationLabel' => $immunisation->vaccination_date 
                    ? Carbon::parse($immunisation->vaccination_date)->format('M d, Y') 
                    : 'Not recorded',
            ];
        });

        // Process timeline immunisations (top 5 most recent)
        $timelineImmunisations = $immunisations->sortByDesc(function ($immunisation) {
            return $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
        })->take(5)->map(function ($immunisation) {
            $timelineDate = $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
            
            return [
                'data' => $immunisation,
                'dateLabel' => $timelineDate 
                    ? Carbon::parse($timelineDate)->format('M d, Y') 
                    : 'Date unavailable',
            ];
        });

        // Calculate statistics
        $totalImmunisations = $immunisations->count();
        $thisYearImmunisations = $immunisations->filter(function ($immunisation) {
            return $immunisation->vaccination_date && 
                   Carbon::parse($immunisation->vaccination_date)->isCurrentYear();
        })->count();

        // Get last updated immunisation
        $lastUpdatedImmunisation = $immunisations->sortByDesc(function ($immunisation) {
            return $immunisation->updated_at ?? $immunisation->vaccination_date ?? $immunisation->created_at;
        })->first();

        $lastUpdatedAt = $lastUpdatedImmunisation 
            ? ($lastUpdatedImmunisation->updated_at ?? $lastUpdatedImmunisation->vaccination_date ?? $lastUpdatedImmunisation->created_at) 
            : null;
        
        $lastUpdatedLabel = $lastUpdatedAt 
            ? Carbon::parse($lastUpdatedAt)->format('M d, Y') 
            : 'Not recorded';

        return view('patient.modules.immunisation.immunisation', [
            'immunisations' => $processedImmunisations,
            'timelineImmunisations' => $timelineImmunisations,
            'totalImmunisations' => $totalImmunisations,
            'thisYearImmunisations' => $thisYearImmunisations,
            'lastUpdatedLabel' => $lastUpdatedLabel,
        ]);
    }

    /**
     * Get a specific immunisation as JSON for the edit modal.
     */
    public function getImmunisationJson(Immunisation $immunisation)
    {
        // Policy/Gate check: Ensure this immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the immunisation data
        return response()->json([
            'immunisation' => $immunisation
        ]);
    }

    /**
     * Show details of a specific immunisation
     */
    public function show(Immunisation $immunisation) {
        // Policy/Gate check: Ensure this immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.immunisation')->with('error', 'Unauthorized access to immunisation.');
        }

        // Process styling data for the immunisation
        $verificationBadgeStyles = match ($immunisation->verification_status) {
            'Provider Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Patient Reported' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'Unverified' => 'bg-gray-100 text-gray-700 border border-gray-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };

        $vaccinationLabel = $immunisation->vaccination_date 
            ? Carbon::parse($immunisation->vaccination_date)->format('F d, Y') 
            : 'Not recorded';

        $createdLabel = $immunisation->created_at 
            ? Carbon::parse($immunisation->created_at)->format('F d, Y') 
            : 'Unknown';

        $updatedLabel = $immunisation->updated_at 
            ? Carbon::parse($immunisation->updated_at)->diffForHumans() 
            : 'Never';

        return view('patient.modules.immunisation.moreInfo', [
            'immunisation' => $immunisation,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'vaccinationLabel' => $vaccinationLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }

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

    /**
     * Update an existing immunisation.
     */
    public function update(Request $request, Immunisation $immunisation)
    {
        // Check if the authenticated patient owns this immunisation
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'dose_details' => 'nullable|string|max:100',
            'vaccination_date' => 'required|date',
            'administered_by' => 'nullable|string|max:255',
            'vaccine_lot_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Use the Model to update the record
        $immunisation->update($validatedData);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Vaccination updated successfully.');
    }

    /**
     * Delete an existing immunisation.
     */
    public function destroy(Immunisation $immunisation)
    {
        // Check if the authenticated patient owns this immunisation
        if ($immunisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Use the Model to delete the record
        $immunisation->delete();

        // Redirect to immunisations page with a success message
        return redirect()->route('patient.immunisation')->with('message', 'Vaccination deleted successfully.');
    }

    /**
     * Upload certificate for an immunisation
     */
    public function uploadCertificate(Request $request, Immunisation $immunisation)
    {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Validate the uploaded file
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240', // Max 10MB, PDF, PNG, JPG, and JPEG only
        ]);

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

            return redirect()
                ->back()
                ->with('success', 'Vaccination certificate uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload certificate. Please try again.');
        }
    }

    /**
     * Delete certificate for an immunisation
     */
    public function deleteCertificate(Request $request, Immunisation $immunisation)
    {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Verify the immunisation belongs to the authenticated patient
        if ($immunisation->patient_id !== $patientId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // Get the file path from the URL
            if ($immunisation->certificate_url) {
                // Extract filename from URL
                $filename = basename($immunisation->certificate_url);
                $filePath = public_path('files/vaccination/' . $filename);

                // Delete the file if it exists
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                // Remove the URL from database
                $immunisation->certificate_url = null;
                $immunisation->save();

                return redirect()
                    ->back()
                    ->with('success', 'Vaccination certificate deleted successfully.');
            }

            return redirect()
                ->back()
                ->with('error', 'No certificate found to delete.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete certificate. Please try again.');
        }
    }

    /**
     * Export all immunisations as PDF
     */
    public function exportPdf() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Get patient information
        $patient = Auth::guard('patient')->user();

        // Get all immunisations for this patient
        $immunisations = Immunisation::where('patient_id', $patientId)->get();

        // Process immunisations for display
        $processedImmunisations = $immunisations->map(function ($immunisation) {
            return [
                'vaccine_name' => $immunisation->vaccine_name,
                'dose_details' => $immunisation->dose_details ?? 'Not specified',
                'vaccination_date' => $immunisation->vaccination_date 
                    ? Carbon::parse($immunisation->vaccination_date)->format('M d, Y') : 'Not recorded',
                'administered_by' => $immunisation->administered_by ?? 'Not specified',
                'vaccine_lot_number' => $immunisation->vaccine_lot_number ?? 'Not specified',
                'notes' => $immunisation->notes ?? 'No additional notes',
            ];
        });

        // Return view that will auto-trigger print dialog for PDF export
        return view('patient.modules.immunisation.exportPdf', [
            'patient' => $patient,
            'immunisations' => $processedImmunisations,
            'exportDate' => Carbon::now()->format('F d, Y'),
            'totalImmunisations' => $immunisations->count(),
            'fileName' => 'Immunisations_' . Carbon::now()->format('Y-m-d'),
        ]);
    }
}
