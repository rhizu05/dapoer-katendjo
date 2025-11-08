@extends('admin.layouts.app')

@section('title', 'Kelola Kategori Menu')

@section('content')
<h1 class="mb-4">Kelola Kategori Menu</h1>

<!-- Notifikasi -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<div class="row">
    <!-- Form Tambah Kategori -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold"><i class="bi bi-plus-circle me-2"></i> Tambah Kategori Baru</div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Kategori</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Kategori -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold"><i class="bi bi-list-ul me-2"></i> Daftar Kategori</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Jumlah Menu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->menus_count }} Menu</td>
                                <td>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus? Menu dalam kategori ini tidak akan ikut terhapus, namun akan kehilangan kategorinya.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection