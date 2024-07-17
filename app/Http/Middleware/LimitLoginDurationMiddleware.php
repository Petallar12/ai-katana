<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import your User model
use Carbon\Carbon;

class LimitLoginDurationMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
        
            if ($user) { // Check if the user object is not null
                $lastActivity = $user->last_activity;
        
                if ($lastActivity && Carbon::now()->diffInMinutes($lastActivity) > 2) {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['timeout' => 'Login session timed out.']);
                }
        
                // Update the last_activity timestamp
                $user->last_activity = Carbon::now();
                $user->save();
            }
        }
        

        return $next($request);
    }
}
