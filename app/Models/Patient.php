<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Patient extends Authenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $primaryKey = 'id';

    protected $fillable = [
        'full_name', 'ic_number', 'phone_number', 'email', 
        'password', 'date_of_birth', 'gender', 'blood_type', 'race', 
        'height', 'weight', 'address', 'postal_code', 'state',
        'emergency_contact_number', 'emergency_contact_name', 
        'emergency_contact_ic_number', 'emergency_contact_relationship', 
        'profile_image_url', 'email_verified_at', 'last_login'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'email_verified_at' => 'datetime'
    ];

    // Username for authentication
    public function username()
    {
        return 'ic_number';
    }

    // Search scope for filtering patients
    public function scopeSearch($query, $searchTerm) {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where(function ($qry) use ($searchTerm) {
            $qry->where('full_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('ic_number', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        });
    }

    /*--- ACCESSORS ---*/
    // Get the formatted Patient ID
    public function getFormattedIdAttribute() {
        return 'P' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    // Get age from date_of_birth
    public function getAgeAttribute() {
        return Carbon::parse($this->date_of_birth)->age;
    }

    // Calculate BMI
    public function getBmiAttribute() {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    // Get full address
    public function getFullAddressAttribute() {
        return $this->address . ', ' . $this->postal_code . ', ' . $this->state;
    }

    /*--- MUTATORS ---*/
    // Set and hash the password
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
}