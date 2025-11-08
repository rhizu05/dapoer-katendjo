@extends('admin.layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
<h1 class="mb-4">Tambah Menu Baru</h1>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Tampilkan Error Validasi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> Periksa kembali input Anda:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)  <-- Loop ini ada di file Anda -->
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required min="0">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Awal</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</Hampir Habis</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image_path" class="form-label">Upload Foto Menu (Opsional)</label>
                <input class="form-control" type="file" id="image_path" name="image_path">
            </div>

            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Simpan Menu</button>
        </form>
    </div>
</div>
@endsection
