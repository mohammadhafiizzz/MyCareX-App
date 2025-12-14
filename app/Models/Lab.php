<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'test_date',
        'file_attachment_url',
        'test_category',
        'facility_name',
        'notes'
    ];

    // casts fields
    protected $casts = [
        'test_date' => 'date:Y-m-d',
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
