@extends('admin.layouts.app')

@section('title', 'Kelola Meja & QR Code')

@section('content')
<h1 class="mb-4">Kelola Meja & QR Code</h1>

<!-- Menampilkan Notifikasi Sukses -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Menampilkan Error Validasi (PENTING: Ini memperbaiki "tombol tambah tidak berfungsi") -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Terdapat masalah saat menyimpan data:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Bagian 1: Form Tambah Meja Baru -->
<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">
        <i class="bi bi-plus-circle me-2"></i> Tambah Meja Baru
    </div>
    <div class="card-body">
        <!-- Form ini terhubung ke TableController@store -->
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf <!-- Token Keamanan Laravel -->
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label for="name" class="form-label">Nama Meja (Contoh: A01, B05)</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="status" class="form-label">Status Awal</label>
                    <select class="form-select" id="status" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Simpan Meja</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bagian 2: Daftar Meja Terdaftar (Data Dinamis) -->
<div class="card shadow-sm">
    <div class="card-header fw-bold">
        <i class="bi bi-list-ul me-2"></i> Daftar Meja Terdaftar
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Meja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data dari database -->
                    @forelse ($tables as $table)
                        <tr>
                            <td>{{ $table->id }}</td>
                            <td>{{ $table->name }}</td>
                            <td>
                                @if ($table->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Generate QR (terhubung ke TableController@showQrCode) -->
                                <a href="{{ route('admin.tables.qr', $table) }}" class="btn btn-sm btn-info me-1" title="Generate QR">
                                    <i class="bi bi-qr-code-scan"></i> QR
                                </a>
                                
                                <!-- Tombol Edit (terhubung ke TableController@edit) -->
                                <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                
                                <!-- Tombol Hapus (terhubung ke TableController@destroy) -->
                                <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja {{ $table->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data meja yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

