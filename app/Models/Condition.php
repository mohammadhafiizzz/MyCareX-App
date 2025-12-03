<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the patient that owns the condition.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that diagnosed the condition.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
