<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan form login untuk Admin/Kasir.
     * Metode ini dipanggil oleh Route::get('/login', ...).
     */
    public function showLoginForm()
    {
        // Memanggil resources/views/admin/auth/login.blade.php
        return view('admin.auth.login');
    }

    /**
     * Memproses permintaan login Admin/Kasir (POST).
     * Metode ini dipanggil oleh Route::post('/login', ...).
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        // 2. Coba otentikasi menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            
            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // Login berhasil, arahkan ke Dashboard Admin (admin.dashboard)
            return redirect()->intended(route('admin.dashboard')); 
        }

        // 3. Otentikasi gagal
        // Melemparkan exception validasi untuk menampilkan pesan error di form
        throw ValidationException::withMessages([
            'email' => ['Email atau Kata Sandi yang Anda masukkan salah.'],
        ]);
    }

    /**
     * Melakukan proses logout Admin/Kasir.
     */
    public function logout(Request $request)
    {
        // Logout menggunakan guard 'admin'
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman login admin
        return redirect()->route('login');
    }
}