<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman Kelola Kategori.
     */
    public function index()
    {
        $categories = Category::withCount('menus')->orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:categories|max:255']);
        Category::create($request->all());
        return back()->with('success', 'Kategori ' . $request->name . ' berhasil ditambahkan.');
    }

    /**
     * Menghapus kategori.
     */
    public function destroy(Category $category)
    {
        // Peringatan: Menghapus kategori akan melepaskan menu terkait (menjadi null)
        $categoryName = $category->name;
        $category->delete();
        return back()->with('success', 'Kategori ' . $categoryName . ' berhasil dihapus.');
    }
}