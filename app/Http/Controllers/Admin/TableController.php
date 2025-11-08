<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator; // Import Validator

class TableController extends Controller
{
    /**
     * Menampilkan daftar meja dan form tambah.
     */
    public function index()
    {
        $tables = Table::orderBy('name', 'asc')->get();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Menyimpan meja baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:tables|max:255',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        // Jika validasi gagal, kembalikan dengan error
        if ($validator->fails()) {
            return redirect()->route('admin.tables.index')
                         ->withErrors($validator)
                         ->withInput(); // Mengembalikan input sebelumnya
        }

        Table::create($request->all());

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Meja baru (' . $request->name . ') berhasil ditambahkan.');
    }

    /**
     * Menampilkan QR Code untuk meja spesifik.
     */
    public function showQrCode(Table $table)
    {
        // Membuat URL unik untuk rute pemesanan pelanggan
        $url = route('client.menu.dinein', $table);

        // Generate QR code
        $qrCode = QrCode::size(300)->generate($url);

        // **PERBAIKAN:** Tambahkan $url ke compact()
        return view('admin.tables.show_qr', compact('qrCode', 'table', 'url'));
    }

    /**
     * Menampilkan form untuk mengedit meja.
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Memperbarui data meja di database.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tables,name,' . $table->id,
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $table->update($request->all());

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Meja ' . $table->name . ' berhasil diperbarui.');
    }


    /**
     * Menghapus meja.
     */
    public function destroy(Table $table)
    {
        $tableName = $table->name;
        $table->delete();

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Meja ' . $tableName . ' berhasil dihapus.');
    }
}

