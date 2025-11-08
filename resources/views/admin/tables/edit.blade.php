@extends('admin.layouts.app')

@section('title', 'Edit Meja: ' . $table->name)

@section('content')
<h1 class="mb-4">Edit Meja: <span class="text-primary">{{ $table->name }}</span></h1>

<!-- Menampilkan Error Validasi (PENTING jika input salah) -->
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

<div class="card shadow-sm">
    <div class="card-header fw-bold">
        <i class="bi bi-pencil-square me-2"></i> Form Edit Meja
    </div>
    <div class="card-body">
        <!-- Form ini terhubung ke TableController@update -->
        <!-- Menggunakan @method('PUT') untuk update resource -->
        <form action="{{ route('admin.tables.update', $table) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Meja</label>
                <!-- Menampilkan data lama di 'value' -->
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $table->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <!-- Memilih status yang aktif berdasarkan data lama -->
                    <option value="aktif" {{ old('status', $table->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $table->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-warning me-2"><i class="bi bi-floppy"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

