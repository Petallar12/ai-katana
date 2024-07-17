<?php

namespace App\Http\Controllers;

use App\Events\ForgotPasswordEvent;
use App\Models\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        
        
        return view('auth.forgot_password');
    }

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
            'email' => 'required',
            'password' => 'required|string|min:6',
            'code' => 'required'
        ]);

        $forgot_password = ForgotPassword::where('code', $request->code)
            ->where('email', $request->email)
            ->first();

        if (!$forgot_password) {
            abort(422, 'Invalid Code');
        }

        $forgot_password->delete();

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->route('home')->with('status', 'Password updated successfully.');

    }

}