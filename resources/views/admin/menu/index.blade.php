@extends('admin.layouts.app')

@section('title', 'Kelola Menu')

@section('content')
<h1 class="mb-4">Kelola Menu</h1>

<!-- Tombol Tambah Menu Baru -->
<a href="{{ route('admin.menu.create') }}" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Tambah Menu Baru</a>

<!-- Notifikasi Sukses -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Notifikasi Error (jika perlu) -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Terjadi kesalahan saat validasi.
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Status</th>
                <th style="width: 280px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
            <tr>
                <td>
                    <img src="{{ $menu->image_path ? asset('storage/' . $menu->image_path) : 'https://placehold.co/100x100?text=Menu' }}" 
                         alt="{{ $menu->name }}" 
                         class="img-thumbnail" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                </td>
                <td>{{ $menu->name }}</td>
                <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td>
                    @if($menu->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Tidak Tersedia</span>
                    @endif
                </td>
                <td>
                    <!-- Form Toggle Status -->
                    <form action="{{ route('admin.menu.toggle.status', $menu) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-{{ $menu->status == 'tersedia' ? 'warning' : 'success' }}">
                            Set {{ $menu->status == 'tersedia' ? 'Habis' : 'Tersedia' }}
                        </button>
                    </form>
                    
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-sm btn-info my-1 my-lg-0"><i class="bi bi-pencil-square"></i> Edit</a>
                    
                    <!-- Form Hapus -->
                    <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data menu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
{{ $menus->links() }}

@endsection
