<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                
                return redirect('/admin/dashboard');
            } elseif ($role === 'receptionist') {
                return redirect('/reception/dashboard');
            }

            // Default fallback: redirect to a safe page
            return redirect('/')->with('success', 'Logged in successfully.');
        }

        // Login failed
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username'); // DO NOT include password here
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out.');
    }
    //
    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username'=> $data['username'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'role' => 'admin',
        ]);

        Auth::login($user);

        return view('auth.login')->with('success', 'Registration successful. Please login.');
        
        
    }

}