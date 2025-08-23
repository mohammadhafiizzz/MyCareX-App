<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Authenticatable
{
    use HasFactory;

    // Primary key
    protected $primaryKey = 'patient_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Table attributes
    protected $fillable = [
        'patient_id',
        'full_name',
        'ic_number',
        'phone_number',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'blood_type',
        'race',
        'height',
        'weight',
        'address',
        'postal_code',
        'state',
        'emergency_contact_number',
        'emergency_contact_name',
        'emergency_contact_ic_number',
        'emergency_contact_relationship',
        'profile_image_url'
    ];

    // Hidden value
    protected $hidden = [
        'password',
        'remember_token'
    ];

    // Automatic data type conversion
    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'email_verified_at' => 'datetime'
    ];

    // Custom attributes
    protected $appends = [
        'age',
        'bmi',
        'full_address'
    ];

    // Auto-generated patient_id primary key
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

    // Accessor for age
    public function getAgeAttribute() {
        return Carbon::parse($this->date_of_birth)->age;
    }

    // Accessor for BMI
    public function getBmiAttribute() {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    // Accessor for full address
    public function getFullAddressAttribute() {
        return $this->address . ', ' . $this->postal_code . ', ' . $this->state;
    }

    // Mutators for password encryption
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    // Search scope
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
