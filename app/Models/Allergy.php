<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'allergen',
        'allergy_type',
        'severity',
        'reaction_desc',
        'status',
        'verification_status',
        'first_observed_date'
    ];

    // casts fields
    protected $casts = [
        'first_observed_date' => 'date:Y-m-d',
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
