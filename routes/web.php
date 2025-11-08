<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\MenuController; 
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\CartController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController; 
use App\Http\Controllers\Admin\Auth\LoginController; 
// Impor Controller
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController; 

/*
|--------------------------------------------------------------------------
| Halaman Awal & Klien (Pelanggan)
|--------------------------------------------------------------------------
*/

// Rute umum jika pelanggan mengakses root tanpa QR (Halaman Instruksi)
Route::get('/', function () {
    // PERBAIKAN DI SINI: Hapus 'cart' juga saat kembali ke welcome
    session()->forget(['order_type', 'table_id', 'table_name', 'cart']); 
    return view('client.welcome'); 
})->name('welcome');

// Grup Rute Klien
Route::group(['as' => 'client.', 'middleware' => ['web']], function () {
    
    // **ENTRY POINT UTAMA (Scan QR):**
    Route::get('/menu/{table_id}', [MenuController::class, 'index'])->name('menu.dinein');

    // **Rute Navigasi Internal:**
    Route::get('/menu', [MenuController::class, 'showMenuGuard'])->name('menu.list');

    // **Rute Profil & Personalisasi**
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); 
    Route::post('/lang/{locale}', [ProfileController::class, 'setLanguage'])->name('set.language'); 
    
    // **RUTE KERANJANG**
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); 
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); 
    Route::post('/cart/update/{menu_id}', [CartController::class, 'update'])->name('cart.update'); 
    Route::get('/cart/remove/{menu_id}', [CartController::class, 'remove'])->name('cart.remove'); 
});

/*
|--------------------------------------------------------------------------
| Admin / Kasir Otentikasi
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| Admin / Kasir (Dilindungi)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    
    // A. Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // B. Kelola Pesanan
    Route::get('orders/dine-in', [OrderController::class, 'dineInOrders'])->name('orders.dinein');
    Route::post('orders/dine-in/{order}/confirm', [OrderController::class, 'confirmPayment'])->name('orders.confirm.payment');
    Route::get('orders/take-away', [OrderController::class, 'createTakeAway'])->name('orders.takeaway');
    Route::post('orders/take-away', [OrderController::class, 'storeTakeAway'])->name('orders.takeaway.store');

    // C. Kelola Menu (Resource Penuh)
    Route::resource('menu', AdminMenuController::class);
    Route::post('menu/{menu}/toggle', [AdminMenuController::class, 'toggleStatus'])->name('menu.toggle.status');

    // C.2 Kelola Kategori
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);

    // D. Kelola Meja & QR (Resource Penuh)
    Route::resource('tables', TableController::class); 
    // **Rute Kustom QR Code**
    Route::get('tables/{table}/qr', [TableController::class, 'showQrCode'])->name('tables.qr');

    // E. Laporan
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');

    // F. Kelola User
    Route::resource('users', UserController::class)->only(['index', 'show']);
});