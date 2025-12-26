<?php

namespace App\Http\Controllers\Modules\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class DeleteController extends Controller
{
    // DELETE: Remove doctor record
    public function destroy(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);

        // Validation logic
        $request->validate([
            'ic_number' => 'required|string',
        ]);

        // Strip hyphens from input IC number
        $inputIc = str_replace('-', '', $request->ic_number);

        // Check if IC number matches
        if ($inputIc !== $doctor->ic_number) {
            return response()->json([
                'success' => false,
                'message' => 'The IC number provided does not match our records.'
            ], 422);
        }

        // Delete profile image if exists
        if ($doctor->profile_image_url && file_exists(public_path($doctor->profile_image_url))) {
            unlink(public_path($doctor->profile_image_url));
        }

        // Delete doctor record
        $doctor->delete();

        return response()->json([
            'success' => true,
            'redirect' => route('organisation.doctors')
        ]);
    }
}
