<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Doctor extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    // primary key
    protected $primaryKey = 'id';

    protected $fillable = [
        'provider_id',
        'full_name',
        'ic_number',
        'email',
        'password',
        'phone_number',
        'medical_license_number',
        'specialisation',
        'active_status',
        'profile_image_url',
        'last_login',
    ];

    // Relationship with HealthcareProvider
    public function provider()
    {
        return $this->belongsTo(HealthcareProvider::class, 'provider_id');
    }

    /*--- MUTATORS ---*/
    // Set and hash the password
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
}
