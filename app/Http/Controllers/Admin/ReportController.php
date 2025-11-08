<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman Laporan Penjualan (E).
     */
    public function salesReport()
    {
        // TODO: Ambil data laporan
        
        // Memanggil view yang akan kita buat
        return view('admin.reports.sales');
    }
    
    // TODO: Tambahkan metode untuk Laporan Menu Terlaris, Export PDF/Excel
}
