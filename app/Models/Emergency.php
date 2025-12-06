<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
        'record_type',
        'record_id',
    ];

    // relationships
    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // morph to record
    public function record() {
        return $this->morphTo();
    }
}