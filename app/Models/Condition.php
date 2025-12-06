<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'condition_name',
        'diagnosis_date',
        'description',
        'severity',
        'status'
    ];

    // casts fields
    protected $casts = [
        'diagnosis_date' => 'date:Y-m-d',
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
