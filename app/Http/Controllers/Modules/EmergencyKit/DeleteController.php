<?php

namespace App\Http\Controllers\Modules\EmergencyKit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Emergency;

class DeleteController extends Controller
{
    public function destroy($id) {
        $patient = Auth::guard('patient')->user();
        
        $emergencyItem = Emergency::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $emergencyItem->delete();

        return redirect()->route('patient.emergency-kit.index')->with('success', 'Item removed from Emergency Kit.');
    }
}
