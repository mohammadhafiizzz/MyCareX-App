<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // morph to record
    public function record(): MorphTo {
        return $this->morphTo();
    }
}