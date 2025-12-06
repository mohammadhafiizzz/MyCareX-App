<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immunisation extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'vaccine_name',
        'dose_details',
        'vaccination_date',
        'administered_by',
        'vaccine_lot_number',
        'verification_status',
        'certificate_url',
        'notes'
    ];

    // casts fields
    protected $casts = [
        'vaccination_date' => 'date:Y-m-d',
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
