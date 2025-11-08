<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    /**
     * Menampilkan halaman Keranjang Belanja.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Ambil data menu dari DB berdasarkan ID di keranjang
        $menuIds = array_keys($cart);
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

        $cartItems = [];
        $totalAmount = 0;

        foreach ($cart as $id => $details) {
            $menu = $menus->get($id);
            if ($menu) {
                $subtotal = $menu->price * $details['quantity'];
                $totalAmount += $subtotal;
                
                $cartItems[] = [
                    'menu_id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $details['quantity'],
                    'image_path' => $menu->image_path,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('client.cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * Menambahkan item ke keranjang (dari tombol di 'list.blade.php').
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::find($request->menu_id);

        // Jika menu tidak tersedia, tolak
        if ($menu->status != 'tersedia') {
            return back()->with('error', 'Menu sedang tidak tersedia.');
        }

        // Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // Cek apakah menu sudah ada di keranjang
        if (isset($cart[$request->menu_id])) {
            // Jika sudah ada, tambahkan jumlahnya
            $cart[$request->menu_id]['quantity'] += $request->quantity;
        } else {
            // Jika belum ada, tambahkan item baru
            $cart[$request->menu_id] = [
                'name' => $menu->name,
                'quantity' => (int)$request->quantity,
                'price' => $menu->price,
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return back()->with('success', $menu->name . ' berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update jumlah item di halaman keranjang.
     */
    public function update(Request $request, $menu_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart');
        if (isset($cart[$menu_id])) {
            $cart[$menu_id]['quantity'] = (int)$request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Jumlah item diperbarui.');
        }
        return back()->with('error', 'Item tidak ditemukan.');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove($menu_id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$menu_id])) {
            unset($cart[$menu_id]); // Hapus item
            session()->put('cart', $cart);
            return back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }
        return back()->with('error', 'Item tidak ditemukan.');
    }
}