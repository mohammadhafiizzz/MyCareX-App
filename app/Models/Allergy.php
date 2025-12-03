<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the patient that owns the allergy.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that diagnosed the allergy.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
