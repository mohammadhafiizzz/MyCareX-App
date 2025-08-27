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

    protected $primaryKey = 'patient_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id', 'full_name', 'ic_number', 'phone_number', 'email', 
        'password', 'date_of_birth', 'gender', 'blood_type', 'race', 
        'height', 'weight', 'address', 'postal_code', 'state',
        'emergency_contact_number', 'emergency_contact_name', 
        'emergency_contact_ic_number', 'emergency_contact_relationship', 
        'profile_image_url', 'email_verified_at'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'email_verified_at' => 'datetime'
    ];

    public function getAuthIdentifierName()
    {
        return 'patient_id';
    }

    public function getAuthIdentifier()
    {
        return $this->patient_id;
    }

    public function username()
    {
        return 'ic_number';
    }

    // Auto-generate patient_id
    protected static function boot() {
        parent::boot();
        
        static::creating(function ($patient) {
            if (!$patient->patient_id) {
                $lastPatient = static::orderBy('patient_id', 'desc')->first();
                $patient->patient_id = $lastPatient 
                    ? 'P' . str_pad((intval(substr($lastPatient->patient_id, 1)) + 1), 4, '0', STR_PAD_LEFT)
                    : 'P0001';
            }
        });
    }

    // Other methods remain the same...
    public function getAgeAttribute() {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getBmiAttribute() {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    public function getFullAddressAttribute() {
        return $this->address . ', ' . $this->postal_code . ', ' . $this->state;
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

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
}