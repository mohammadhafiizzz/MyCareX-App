<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
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
     * Get the patient that owns the allergies.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
