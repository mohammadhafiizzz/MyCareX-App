<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\Patient;
use App\Models\HealthcareProvider;
use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Custom password reset URL for different models
        ResetPassword::createUrlUsing(function ($user, string $token) {
            if ($user instanceof Patient) {
                return route('patient.password.reset', ['token' => $token, 'email' => $user->email]);
            } elseif ($user instanceof HealthcareProvider) {
                return route('organisation.password.reset', ['token' => $token, 'email' => $user->email]);
            } elseif ($user instanceof Admin) {
                return route('admin.password.reset', ['token' => $token, 'email' => $user->email]);
            } elseif ($user instanceof Doctor) {
                return route('doctor.password.reset', ['token' => $token, 'email' => $user->email]);
            }
            
            // Default fallback
            return route('password.reset', ['token' => $token, 'email' => $user->email]);
        });
    }
}
