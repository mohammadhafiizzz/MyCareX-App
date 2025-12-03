<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // relationships
    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}