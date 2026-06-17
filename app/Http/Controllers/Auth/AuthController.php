<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:buyer,seller', // Admin created manually or via seed
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => Carbon::now(),
        ]);

        Auth::login($user);
        
        return $this->redirectBasedOnRole();
    }

    public function showOtpVerify($id)
    {
        return view('auth.verify-otp', ['userId' => $id]);
    }

    public function verifyOtp(Request $request, $id)
    {
        $request->validate(['otp' => 'required']);
        $user = User::findOrFail($id);

        if ($user->otp === $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expiry)) {
            $user->email_verified_at = Carbon::now();
            $user->otp = null;
            $user->otp_expiry = null;
            $user->save();

            Auth::login($user);
            return $this->redirectBasedOnRole();
        }

        return back()->with('error', 'Invalid or expired OTP');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function redirectBasedOnRole()
    {
        $role = Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'seller') return redirect()->route('seller.dashboard');
        return redirect()->route('home');
    }
}
