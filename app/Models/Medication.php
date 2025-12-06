<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    // fillable fields
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medication_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date',
        'notes',
        'status',
        'reason_for_med',
        'med_image_url'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'dosage' => 'integer',
    ];

    // Get the patient that owns the condition.
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Get the doctor that diagnosed the condition.
    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Get formatted dosage with unit
     */
    public function getFormattedDosageAttribute()
    {
        return $this->attributes['dosage'] ? $this->attributes['dosage'] . ' mg' : 'No dosage recorded';
    }

    /**
     * Mutator: Store only integer value, remove any text/units
     */
    public function setDosageAttribute($value)
    {
        // If already an integer, just store it
        if (is_int($value)) {
            $this->attributes['dosage'] = $value;
            return;
        }
        
        // Extract numeric value from input (handles "500", "500mg", "500 mg", etc.)
        $this->attributes['dosage'] = is_numeric($value) ? (int)$value : (int)preg_replace('/[^0-9]/', '', $value);
    }
}
