@extends('admin.layouts.app')

@section('title', 'Edit Menu: ' . $menu->name)

@section('content')
<h1 class="mb-4">Edit Menu: {{ $menu->name }}</h1>

<div class="card shadow-sm">
    <div class="card-body">
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

        <form action="{{ route('admin.menu.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="name" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori (Opsional)</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $menu->price) }}" required min="0">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="tersedia" {{ old('status', $menu->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status', $menu->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image_path" class="form-label">Upload Foto Menu Baru (Opsional)</label>
                <br>
                @if($menu->image_path)
                    <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="img-thumbnail mb-2" style="width: 150px;">
                    <p><small>Gambar saat ini. Upload file baru untuk mengganti.</small></p>
                @else
                    <p><small>Belum ada gambar.</small></p>
                @endif
                <input class="form-control" type="file" id="image_path" name="image_path">
            </div>

            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Update Menu</button>
        </form>
    </div>
</div>
@endsection