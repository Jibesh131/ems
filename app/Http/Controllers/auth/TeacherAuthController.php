<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAuthController extends Controller
{
    public function loginView()
    {
        return view('auth.teacher.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withInput()->with('error', 'Invalid credentials.');
        }

        if (Auth::user()->role !== 'teacher') {
            Auth::logout();
            return back()->withInput()->with('error', 'You are not authorized to access this area.');
        }

        $request->session()->regenerate();
        return redirect()->route('teacher.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login.view');
    }
}
