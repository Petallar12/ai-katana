<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notifications\ForgotPasswordNotification;
use App\Notifications\ForgotPasswordCodeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log; // Import the Log facade

class SendForgotPasswordNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }


    
    public function handle($event)
    {
        try {
            $forgot_password = $event->forgot_password;
            $user = User::where('email', $forgot_password->email)->first();
            
            if (!$user) {
                // Handle the case when the user is not found
                Log::warning("User not found for email: " . $forgot_password->email);
                return;
            }
    
            Notification::send($user, new ForgotPasswordNotification($forgot_password, $user));
        } catch (\Exception $e) {
            // Handle the exception here
            Log::error("An error occurred: " . $e->getMessage());
        }
    }
}