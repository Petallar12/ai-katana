<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(){

        if (!(auth()->user()->role == 'IT admin')) {
            abort(404, 'Cannot Access');
        }
    return view('/registration');
}

public function store(Request $request)
{
    if (!(auth()->user()->role == 'IT admin')) {
        abort(404, 'Cannot Access');
    }
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string',
    ]);

    // Create a new user using request data
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password), // Make sure to hash the password
        'role' => $request->role,
    ]);
        // Log out the current user
        Auth::logout();

        // Redirect to the login page
        return redirect()->route('login')->with(['message' => 'User registered successfully! Please log in.', 'status' => 'success']);
    }
}