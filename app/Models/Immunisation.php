<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the patient that owns the immunisation.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that administered the immunisation.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
