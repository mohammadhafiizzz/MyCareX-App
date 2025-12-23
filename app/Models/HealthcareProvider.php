<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\HealthcareProviderVerifyEmail;

class HealthcareProvider extends Authenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $primaryKey = 'id';

    // fillable fields
    protected $fillable = [
        'organisation_name', 'organisation_type', 'registration_number', 
        'license_number', 'license_expiry_date', 'establishment_date', 
        'email', 'password', 'phone_number', 'emergency_contact', 
        'website_url', 'contact_person_name', 'contact_person_phone_number', 
        'contact_person_designation', 'registration_date', 'contact_person_ic_number', 
        'address', 'postal_code', 'state', 'business_license_document', 
        'medical_license_document', 'profile_image_url', 'verification_status', 
        'verified_by', 'approved_at', 'rejected_at', 'rejection_reason',
        'email_verified_at', 'last_login'
    ];

    // hidden fields
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'license_expiry_date' => 'date',
            'establishment_date' => 'date',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    // the username field for authentication
    public function username() {
        return 'email';
    }

    // Search scope for filtering healthcare providers
    public function scopeSearch($query, $searchTerm) {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->where(function ($qry) use ($searchTerm) {
            $qry->where('organisation_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('organisation_type', 'like', '%' . $searchTerm . '%')
                ->orWhere('registration_number', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone_number', 'like', '%' . $searchTerm . '%');
        });
    }

    // Send the email verification notification
    public function sendEmailVerificationNotification() {
        $this->notify(new HealthcareProviderVerifyEmail);
    }

    /*--- ACCESSORS ---*/
    // Get the formatted Healthcare Provider ID
    public function getFormattedIdAttribute() {
        return 'HCP' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    // Get the full address attribute
    public function getFullAddressAttribute() {
        return "{$this->address}, {$this->postal_code} {$this->state}";
    }

    /*--- MUTATORS ---*/
    // Set the password attribute and hash it
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    /*--- RELATIONSHIPS ---*/
    // Get the doctors associated with the healthcare provider
    public function doctors() {
        return $this->hasMany(Doctor::class, 'provider_id');
    }
}
