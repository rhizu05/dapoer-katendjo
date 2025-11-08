<?php

namespace App\Http\Controllers\Client; // <--- PASTIKAN NAMESPACE INI BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pelanggan.
     */
    public function index()
    {
        // Panggil view yang sudah Anda buat sebelumnya:
        return view('client.profile'); 
    }
}