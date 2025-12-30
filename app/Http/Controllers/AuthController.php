<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Owner;

class AuthController extends Controller
{
    // =========================
    // FORM LOGIN
    // =========================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =========================
    // PROSES LOGIN
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // Cek owner (khusus owner & kasir)
        if (in_array($user->role, ['owner', 'kasir'])) {

            $owner = Owner::find($user->owner_id);

            if (!$owner || $owner->status !== 'aktif') {
                return back()->with('error', 'Akun owner tidak aktif');
            }

            if ($owner->expired_at && now()->gt($owner->expired_at)) {
                return back()->with('error', 'Masa aktif aplikasi telah habis');
            }
        }

        Auth::login($user);

        // Redirect by role
        return redirect()->route('dashboard');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
