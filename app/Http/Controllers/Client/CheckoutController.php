<?php

namespace App\Http\Controllers\Client; // <--- PASTIKAN NAMESPACE INI BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    $orderData = [
        'table_id' => session('table_id'),
        'total_amount' => $cartTotal,
        'status' => 'PENDING_PAYMENT',
        // ... data lainnya
    ];

    // LOGIKA KUNCI: Cek apakah pelanggan sedang login
    if (Auth::guard('web')->check()) {
        $orderData['user_id'] = Auth::guard('web')->id();
    }
    
    // Simpan pesanan. 
    // Jika tamu, user_id akan null. Jika login, user_id akan terisi.
    $order = Order::create($orderData);
    ```