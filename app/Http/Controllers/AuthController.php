<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required',
            'role' => 'required|in:user,admin',
        ]);

        $identifier = $request->identifier;

        // Admin login check
        if (($identifier === '1111111111' || $identifier === 'admin@vogue.com') && $request->password === 'vogue123') {
            if ($request->role !== 'admin') {
                return back()->withErrors(['identifier' => 'This credential cannot be used for user login.']);
            }

            session([
                'admin_id' => 0,
                'admin_mobile' => 'admin@vogue.com',
                'is_admin' => true,
            ]);

            return redirect()->route('admin.dashboard');
        }

        // User login - check by email or mobile
        if ($request->role === 'user') {
            $user = User::where('role', 'user')
                ->where(function ($query) use ($identifier) {
                    $query->where('email', $identifier)
                          ->orWhere('mobile', $identifier);
                })
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);

                if (session()->has('redirect_after_login')) {
                    $redirect = session('redirect_after_login');
                    session()->forget('redirect_after_login');
                    return redirect($redirect);
                }

                return redirect()->route('home')->with('success', 'Welcome back!');
            }

            return back()->withErrors(['identifier' => 'Invalid email/mobile or password.']);
        }

        return back()->withErrors(['identifier' => 'Invalid login details or role mismatch.']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'mobile' => 'required|string|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'first_name.regex' => 'First name should only contain letters.',
            'last_name.regex' => 'Last name should only contain letters.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Welcome back!');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();

        return redirect()->route('home')->with('success', 'Welcome back!');
    }
}
