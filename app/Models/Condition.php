<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{

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
        'diagnosis_date' => 'date',
    ];
}
