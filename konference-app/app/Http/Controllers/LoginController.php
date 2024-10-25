<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // view form for login
    }

    public function login(Request $request)
    {
        // validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // attempt to login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // session ID 
            return redirect()->intended('/'); // redirect to main page
        }

        // if login fails
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); // for security

        return redirect('/'); // redirect to main page
    }
}
