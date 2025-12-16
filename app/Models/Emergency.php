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

    // Static helper to check if patient has any emergency records
    public static function hasAnyRecords($patientId) {
        return self::where('patient_id', $patientId)->exists();
    }

    // Get counts by type for a patient
    public static function getCountsByType($patientId) {
        return [
            'conditions' => self::where('patient_id', $patientId)
                ->where('record_type', Condition::class)
                ->count(),
            'medications' => self::where('patient_id', $patientId)
                ->where('record_type', Medication::class)
                ->count(),
            'allergies' => self::where('patient_id', $patientId)
                ->where('record_type', Allergy::class)
                ->count(),
        ];
    }
}