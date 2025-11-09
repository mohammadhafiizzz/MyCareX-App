<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    // primary key
    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'patient_id',
        'test_name',
        'test_date',
        'file_attachment_url',
        'test_category',
        'facility_name',
        'verification_status',
        'notes'
    ];

    // casts fields
    protected $casts = [
        'test_date' => 'date:Y-m-d',
    ];
}
