<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show()
    {
         return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // This checks the users table and the hashed password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // prevents session fixation
            return redirect()->route('role-access.index');
            // return redirect()->intended(route('storage.index'));
        }


        return back()->with('error', 'Invalid credentials.');
       
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
        // return redirect(route('home'));
    }
}