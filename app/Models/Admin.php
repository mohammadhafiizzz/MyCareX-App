<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Admin extends Authenticatable implements CanResetPasswordContract, MustVerifyEmail
{
    use HasFactory, Notifiable, CanResetPassword;
5
    protected $primaryKey = 'admin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'admin_id', 'full_name', 'ic_number', 'phone_number', 'email', 
        'password', 'role', 'email_verified_at', 'profile_image_url'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Auto-generate admin_id
    protected static function boot() {
        parent::boot();

        static::creating(function ($admin) {
            if (!$admin->admin_id) {
                $lastAdmin = static::orderBy('admin_id', 'desc')->first();
                if ($lastAdmin) {
                    $lastIdNumber = (int) substr($lastAdmin->admin_id, 3);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1;
                }
                $admin->admin_id = 'MCX' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    /*--- ACCESSORS ---*/
    // Get the auth Admin ID
    public function getAuthIdentifierName()
    {
        return 'admin_id';
    }

    // Get the auth Admin ID value
    public function getAuthIdentifier()
    {
        return $this->admin_id;
    }

    // Username for authentication
    public function username()
    {
        return 'admin_id';
    }

    /*--- MUTATORS ---*/
    // Set hash password before saving
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
}
