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

    protected $primaryKey = 'admin_id';
    protected $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'admin_id', 'full_name', 'ic_number', 'phone_number', 'email', 
        'password', 'role', 'email_verified_at', 'profile_image_url'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'admin_id';
    }

    public function getAuthIdentifier()
    {
        return $this->admin_id;
    }

    public function username()
    {
        return 'admin_id';
    }

    // Auto-generate admin_id
}
