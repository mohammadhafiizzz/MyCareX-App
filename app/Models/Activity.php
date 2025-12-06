<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function user() {
        return $this->morphTo();
    }

    public function record() {
        return $this->morphTo();
    }
}