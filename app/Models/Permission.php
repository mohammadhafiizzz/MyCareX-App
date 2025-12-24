<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'patient_id',
        'provider_id',
        'doctor_id',
        'requested_at',
        'granted_at',
        'status',
        'expiry_date',
        'permission_scope',
        'notes'
    ];

    protected $casts = [
        'permission_scope' => 'array',
        'requested_at' => 'datetime',
        'granted_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    // Get the patient that owns the condition.
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Get the provider that is granted the permission.
    public function provider() {
        return $this->belongsTo(HealthcareProvider::class, 'provider_id');
    }

    // Get the doctor that diagnosed the condition.
    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}