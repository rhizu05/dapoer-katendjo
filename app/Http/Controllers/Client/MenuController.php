<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Table; 

class MenuController extends Controller
{
    /**
     * MENANGKAP ID MEJA, MEMVALIDASI, MENYIMPAN, DAN MENAMPILKAN MENU.
     */
    public function index($table_id)
    {
        // 1. Validasi Meja (Apakah meja /menu/3 ada dan aktif?)
        $table = Table::where('id', $table_id)
                      ->where('status', 'aktif') 
                      ->first(); 

        if (!$table) {
            return redirect()->route('welcome')
                             ->with('error', 'Meja tidak ditemukan atau sedang tidak tersedia. Silakan pindai QR Code yang valid.');
        }

        // --- PERBAIKAN BUG PINDAH MEJA (START) ---
        
        $currentTableId = session('table_id');
        
        // Cek jika pelanggan pindah meja (scan QR baru padahal sesi lama ada)
        // $currentTableId ada DAN $currentTableId TIDAK SAMA DENGAN $table->id baru
        if ($currentTableId && $currentTableId != $table->id) {
            
            // Hapus keranjang dari sesi lama agar keranjang baru kosong
            session()->forget('cart');
        }
        // --- PERBAIKAN BUG PINDAH MEJA (END) ---


        // 2. Kunci ID Meja di Sesi (Menimpa sesi lama/membuat baru)
        session()->put('order_type', 'dine_in');
        session()->put('table_id', $table->id); 
        session()->put('table_name', $table->name); // Simpan nama meja (A01) untuk ditampilkan
        
        // 3. Ambil data menu yang sudah dikelompokkan
        list($categories, $uncategorizedMenus) = $this->getGroupedMenus();
        
        // 4. Langsung tampilkan view menu
        return view('client.menu.list', compact('categories', 'uncategorizedMenus')); 
    }
    
    /**
     * Metode ini digunakan untuk navigasi internal (GUARD) setelah sesi dibuat
     */
    public function showMenuGuard()
    {
        // Pastikan sesi ID Meja ada sebelum menampilkan menu
        if (!session()->has('table_id') || session('order_type') !== 'dine_in') {
            return redirect()->route('welcome')->with('error', 'Sesi meja tidak ditemukan. Silakan pindai QR code.');
        }

        // Ambil data menu yang sudah dikelompokkan
        list($categories, $uncategorizedMenus) = $this->getGroupedMenus();
        
        // Tampilkan view menu
        return view('client.menu.list', compact('categories', 'uncategorizedMenus'));
    }

    /**
     * Helper private function untuk mengambil menu yang dikelompokkan berdasarkan kategori.
     * (Versi ini mengambil SEMUA menu, termasuk yang 'tidak tersedia')
     */
    private function getGroupedMenus()
    {
        // 1. Ambil semua kategori, dan muat SEMUA menu (tersedia maupun tidak)
        $categories = Category::with('menus')->get();

        // 2. Ambil semua menu yang tidak punya kategori (tersedia maupun tidak)
        $uncategorizedMenus = Menu::whereNull('category_id')->get();

        return [$categories, $uncategorizedMenus];
    }
}