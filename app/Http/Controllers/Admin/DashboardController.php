<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // <--- TAMBAHKAN BARIS INI

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard dengan ringkasan metrik utama.
     */
    public function index()
    {
        // 1. Jumlah Pesanan Hari Ini
        $todayOrdersCount = Order::whereDate('created_at', today())->count();
        
        // 2. Pesanan Sedang Diproses (Asumsi status 'processing' atau 'DAPUR_QUEUE')
        $processingOrdersCount = Order::where('status', 'DAPUR_QUEUE')->count();
        
        // 3. Notifikasi Pembayaran Pending (Pembayaran Via Kasir/Payment Gateway Pending)
        $pendingPaymentsCount = Order::where('order_type', 'dine_in')
                                      ->where('is_paid', false)
                                      ->count();

        // Mengarahkan ke resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact('todayOrdersCount', 'processingOrdersCount', 'pendingPaymentsCount'));
    }
}
