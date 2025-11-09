<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immunisation extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
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
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
