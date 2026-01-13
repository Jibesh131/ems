<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function loginView()
    {
        return view('auth.user.login');
    }

    public function loginPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'remember' => 'nullable',
        ]);
        $remember = isset($validated['remember']) && $validated['remember'] === 'on';

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $remember)) {
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function signUpView()
    {
        return view('auth.user.signup');
    }

    public function signUpPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|max:20',
            'password' => 'required|min:8',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            // max 2MB
        ]);
        $path = uploadImage($request->file('profile_pic'), 'profile_pics/students');

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->profile_pic = $path;
            $user->save();
            DB::commit();
            Auth::login($user);
        } catch (\Throwable $e) {
            DB::rollBack();
            Auth::logout();
            throw $e;
        }
        return redirect()->route('user.dashboard')->with('message', [
            'status' => 'success',
            'title'  => 'Welcome!',
            'msg'    => 'Your account has been created successfully. We’re glad to have you with us.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login.view');
    }
}
