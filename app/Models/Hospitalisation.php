<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitalisation extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'admission_date',
        'discharge_date',
        'reason_for_admission',
        'provider_name',
        'notes',
        'verification_status',
    ];

    // Get the patient that owns the condition.
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Get the doctor that diagnosed the condition.
    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}