<?php

namespace App\Http\Controllers\Modules\Immunisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immunisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Permission;

class CreateController extends Controller
{
    // Show Doctor Add Immunisation Form
    public function showDoctorForm() {
        $doctorId = Auth::guard('doctor')->id();
        
        $permissions = Permission::where('doctor_id', $doctorId)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->with('patient')
            ->get();
            
        $patients = collect();
        
        foreach ($permissions as $permission) {
            $scope = $permission->permission_scope ?? [];
            if (in_array('all', $scope) || in_array('immunisations', $scope)) {
                if ($permission->patient) {
                    $patients->push($permission->patient);
                }
            }
        }
        
        return view('doctor.modules.medicalRecord.create.addVaccination', compact('patients'));
    }

    // Store immunisation by Doctor
    public function storeDoctor(Request $request) {
        $doctorId = Auth::guard('doctor')->id();

        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vaccine_name' => 'required|string|max:255',
            'dose_details' => 'nullable|string|max:100',
            'vaccination_date' => 'required|date',
            'administered_by' => 'nullable|string|max:255',
            'vaccine_lot_number' => 'nullable|string|max:100',
            'certificate' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
            'notes' => 'nullable|string',
        ]);

        // Verify Permission
        $permission = Permission::where('doctor_id', $doctorId)
            ->where('patient_id', $request->patient_id)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->first();

        if (!$permission) {
            return redirect()->back()->with('error', 'You do not have permission to access this patient\'s records.');
        }

        $scope = $permission->permission_scope ?? [];
        if (!in_array('all', $scope) && !in_array('immunisations', $scope)) {
            return redirect()->back()->with('error', 'You do not have permission to add immunisations for this patient.');
        }

        // Add doctor_id
        $validatedData['doctor_id'] = $doctorId;

        // Create new immunisation record
        $immunisation = Immunisation::create($validatedData);

        // Handle optional certificate upload
        if ($request->hasFile('certificate')) {
            try {
                $file = $request->file('certificate');
                $destinationPath = public_path('files/vaccination');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $immunisationId = $immunisation->id;
                $baseName = 'Vaccination_' . $immunisationId . '_Certificate';
                $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
                $filename = $baseName . '.' . $extension;

                $file->move($destinationPath, $filename);
                $publicUrl = asset('files/vaccination/' . $filename);

                $immunisation->certificate_url = $publicUrl;
                $immunisation->save();
            } catch (\Exception $e) {
                return redirect()->route('doctor.medical.records')->with('warning', 'Vaccination added successfully, but certificate upload failed.');
            }
        }

        return redirect()->route('doctor.medical.records')->with('success', 'Vaccination added successfully');
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
}
