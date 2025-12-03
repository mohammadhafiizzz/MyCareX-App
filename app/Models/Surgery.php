<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable =[
        'patient_id',
        'doctor_id',
        'procedure_name',
        'procedure_date',
        'surgeon_name',
        'hospital_name',
        'notes',
        'verification_status',
    ];

    // relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
