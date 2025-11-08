<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Model Pelanggan (bukan AdminUser)
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun pengguna (pelanggan) yang terdaftar.
     */
    public function index()
    {
        // Ambil pelanggan dan hitung jumlah pesanan mereka
        $users = User::withCount('orders')->orderBy('name', 'asc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan detail pengguna dan riwayat pembeliannya.
     */
    public function show(User $user)
    {
        // Ambil data user, beserta relasi 'orders'
        // Kita juga bisa memuat relasi 'meja' dari pesanan (jika perlu)
        $user->load(['orders' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.users.show', compact('user'));
    }
}