<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail; // Pastikan ini di-import
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\DB; // Pastikan ini di-import
use Exception; // Pastikan ini di-import

class OrderController extends Controller
{
    /**
     * Menampilkan Daftar Pesanan Dine-In.
     */
    public function dineInOrders()
    {
        $orders = Order::where('order_type', 'dine_in')
                       ->orderBy('id', 'desc')
                       ->paginate(15);
                       
        return view('admin.orders.dinein', compact('orders'));
    }

    /**
     * Konfirmasi Pembayaran Kasir (Dine-In).
     */
    public function confirmPayment(Order $order)
    {
        if (!$order->is_paid) {
            $order->update([
                'is_paid' => true,
                'status' => 'DAPUR_QUEUE', 
            ]);
            
            // TODO: Kirim event notifikasi ke dapur (WebSocket)
            
            return back()->with('success', 'Pembayaran pesanan ' . $order->id . ' berhasil dikonfirmasi.');
        }
        
        return back()->with('warning', 'Pembayaran sudah lunas.');
    }

    /**
     * Menampilkan Form Input Pesanan Take-Away (B.2).
     */
    public function createTakeAway()
    {
        // Kebutuhan: admin dapat menginputkan menu yang tersedia
        $categories = Category::with(['menus' => function($query) {
                                $query->where('status', 'tersedia')->orderBy('name', 'asc');
                            }])
                            ->orderBy('name', 'asc')
                            ->get();

        $uncategorizedMenus = Menu::where('status', 'tersedia')
                                  ->whereNull('category_id')
                                  ->orderBy('name', 'asc')
                                  ->get();
        
        return view('admin.orders.takeaway_input', compact('categories', 'uncategorizedMenus'));
    }
    
    /**
     * Menyimpan Pesanan Take-Away yang diinput Kasir.
     * (Versi ini menyimpan 'notes' dari keranjang)
     */
    public function storeTakeAway(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
            'cart' => 'required|json', // Keranjang dikirim sebagai JSON dari Alpine.js
        ]);

        $cartItems = json_decode($request->cart, true);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang tidak boleh kosong.');
        }

        // Amankan transaksi dengan DB Transaction
        try {
            DB::beginTransaction();

            // 1. Hitung ulang Total di Server (Jangan percaya total dari Klien)
            $totalAmount = 0;
            $menuIds = array_column($cartItems, 'id');
            $menusFromDB = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

            foreach ($cartItems as $item) {
                if (!isset($menusFromDB[$item['id']])) {
                    throw new Exception('Menu dengan ID ' . $item['id'] . ' tidak ditemukan.');
                }
                $totalAmount += $menusFromDB[$item['id']]->price * $item['quantity'];
            }

            // 2. Buat Pesanan (Order)
            $order = Order::create([
                'order_type' => 'take_away',
                'customer_name' => $request->customer_name, // Kebutuhan: input nama pelanggan
                'status' => 'DAPUR_QUEUE', // Langsung kirim ke koki
                'is_paid' => true, // Diasumsikan langsung lunas di kasir
                'total_amount' => $totalAmount, // Kebutuhan: total pesanan
                'verified_by' => auth('admin')->id(), // ID Kasir/Admin yang input
            ]);

            // 3. Buat Detail Pesanan (Order Details)
            foreach ($cartItems as $item) {
                $menu = $menusFromDB[$item['id']];
                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price, 
                    'notes' => $item['notes'] ?? null // <-- Menyimpan catatan
                ]);
            }

            DB::commit();

            // TODO: Kirim event notifikasi ke dapur (WebSocket)
            // event(new OrderCreated($order));

            return redirect()->route('admin.orders.dinein')->with('success', 'Pesanan Take-Away berhasil dibuat (ID: ' . $order->id . ') dan dikirim ke dapur.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }
}