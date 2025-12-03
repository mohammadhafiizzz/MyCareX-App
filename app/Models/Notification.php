<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'related_type',
        'related_id',
        'message',
        'read_at',
    ];

    // timestamps
    public $timestamps = true;

    // relationships
    public function notifiable(): MorphTo {
        return $this->morphTo();
    }

    // morph to related
    public function related(): MorphTo {
        return $this->morphTo();
    }
}