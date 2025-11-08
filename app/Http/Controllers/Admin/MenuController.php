<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category; // <-- IMPORT KATEGORI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Mengambil kategori untuk form tambah
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id', // Validasi kategori
        ]);

        $data = $request->except('image_path');

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('menu_images', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     * (PERBARUI METODE INI)
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all(); // <-- AMBIL DATA KATEGORI
        return view('admin.menu.edit', compact('menu', 'categories')); // <-- KIRIM KE VIEW
    }

    /**
     * Update the specified resource in storage.
     * (METODE INI SUDAH BENAR)
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id', // Validasi kategori
        ]);

        $data = $request->except('image_path');

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada
            if ($menu->image_path) {
                Storage::disk('public')->delete($menu->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('menu_images', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Hapus gambar dari storage
        if ($menu->image_path) {
            Storage::disk('public')->delete($menu->image_path);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Mengubah Status Ketersediaan (C).
     */
    public function toggleStatus(Menu $menu)
    {
        $newStatus = ($menu->status === 'tersedia') ? 'tidak tersedia' : 'tersedia';
        $menu->update(['status' => $newStatus]);
        
        return back()->with('success', 'Status menu ' . $menu->name . ' berhasil diubah menjadi ' . $newStatus);
    }
}