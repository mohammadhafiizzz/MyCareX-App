<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
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
     * Get the patient that owns the conditions.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
