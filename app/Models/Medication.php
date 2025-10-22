<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
        'provider_id',
        'medication_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date',
        'notes',
        'status',
        'reason_for_med'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];
}
