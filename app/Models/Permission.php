<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'patient_id',
        'provider_id',
        'requested_at',
        'granted_at',
        'status',
        'expiry_date',
        'permission_scope',
        'notes'
    ];

    protected $casts = [
        'permission_scope' => 'array',
        'requested_at' => 'date',
        'granted_at' => 'date',
        'expiry_date' => 'date',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function provider()
    {
        return $this->belongsTo(HealthcareProvider::class, 'provider_id');
    }
}