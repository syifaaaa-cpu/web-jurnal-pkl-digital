<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

  // Memproses otentikasi login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pengalihan dinamis berdasarkan role user dari database
            if ($user->role === 'siswa') {
                return redirect()->intended('/dashboard/siswa');
            } elseif ($user->role === 'mentor') {
                return redirect()->intended('/dashboard/mentor-dudi');
            } elseif ($user->role === 'pembimbing') {
                return redirect()->intended('/dashboard/pembimbing');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/dashboard/Admin');
            }

            // Fallback default jika role tidak dikenali
            return redirect()->intended('/dashboard/siswa');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
