<?php

namespace App\Http\Controllers\Modules\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class ReadController extends Controller
{
    // READ: Show Doctor Profile Page
    public function doctorProfile($id) {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';
        $totalDoctors = $organisation->doctors()->count();

        // Get doctor details
        $doctor = Doctor::where('id', $id)
            ->where('provider_id', $organisation->id)
            ->firstOrFail();

        return view('organisation.modules.doctor.doctorProfile', compact('organisation', 'isVerified', 'doctor', 'totalDoctors'));
    }

    // READ: Show Add Doctor Form
    public function addDoctor() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';
        $totalDoctors = $organisation->doctors()->count();

        return view('organisation.modules.doctor.addDoctor', compact('organisation', 'isVerified', 'totalDoctors'));
    }

    // READ: Show Doctors List
    public function doctor() {
        // Get authenticated organisation id
        $organisationId = Auth::guard('organisation')->id() ?? Auth::id();

        // Check if the organisation is verified
        $organisation = Auth::guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';

        // Check if organisation is authenticated
        if (!$organisationId) {
            return redirect()->route('organisation.login');
        }

        // Get doctors associated with the organisation
        $doctors = Doctor::where('provider_id', $organisationId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalDoctors = $doctors->count();

        return view('organisation.modules.doctor.doctorList', compact('doctors', 'isVerified', 'totalDoctors'));
    }

    // READ: Show edit doctor form
    public function edit($id) {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';
        $totalDoctors = $organisation->doctors()->count();

        // Get doctor details
        $doctor = Doctor::where('id', $id)
            ->where('provider_id', $organisation->id)
            ->firstOrFail();

        return view('organisation.modules.doctor.editDoctor', compact('organisation', 'isVerified', 'doctor', 'totalDoctors'));
    }
}
