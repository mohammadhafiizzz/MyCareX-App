<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check which guard is being used based on the route
            if ($request->is('patient/*')) {
                return route('patient.login.form');
            }
            
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            
            if ($request->is('doctor/*')) {
                return route('doctor.login');
            }
            
            if ($request->is('organisation/*')) {
                return route('organisation.login');
            }
            
            // Default fallback
            return route('index');
        }
        
        return null;
    }

    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        // Add session flash message for UI notification
        session()->flash('session_expired', 'Your session has expired. Please login again to continue.');
        
        parent::unauthenticated($request, $guards);
    }
}