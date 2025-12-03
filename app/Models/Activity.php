<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'user_type',
        'user_id',
        'record_type',
        'record_id',
        'action',
        'changes_made',
    ];

    // casts
    protected $casts = [
        'changes_made' => 'array',
    ];

    // timestamps
    public $timestamps = true;

    // relationships
    public function user(): MorphTo {
        return $this->morphTo();
    }

    public function record(): MorphTo {
        return $this->morphTo();
    }
}