<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            abort(422, 'Invalid Email');
        }

        $code = sprintf("%06d", mt_rand(1, 999999));

        $forgot_password = ForgotPassword::create([
            'email' => $request->email,
            'code' => $code
        ]);

        event(new ForgotPasswordEvent($forgot_password));

        return response()->json([
            'message' => 'Code is Sent to Email'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'code' => 'required'
        ]);
    
        $forgot_password = ForgotPassword::where('code', $request->code)
            ->where('email', $request->email)
            ->first();
    
        if (!$forgot_password) {
            abort(422, 'Invalid Code');
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            abort(422, 'User not found');
        }
    
        // You should check if the token is still valid here, maybe by comparing with the created_at timestamp
    
        // Delete the forgot password record
        $forgot_password->delete();
    
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json([
            'message' => 'Password Updated'
        ]);
    }
    use SendsPasswordResetEmails;
}
