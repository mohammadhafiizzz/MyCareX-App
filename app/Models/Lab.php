<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'verification_status',
        'notes'
    ];

    // casts fields
    protected $casts = [
        'test_date' => 'date:Y-m-d',
    ];

    /**
     * Get the patient that owns the lab test.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor that ordered the lab test.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
