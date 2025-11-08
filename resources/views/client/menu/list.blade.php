@extends('client.layouts.app')

@section('title', 'Menu | Meja ' . session('table_name', session('table_id')))

@push('styles')
<style>
/* ... (style .card-img-top-menu dan .menu-grayscale Anda) ... */
    .card-img-top-menu {
        height: 200px;
        object-fit: cover; 
    }
    .menu-grayscale {
        filter: grayscale(100%);
        opacity: 0.6;
    }
</style>
@endpush

@section('content')
<header class="p-4 text-center bg-warning text-dark shadow-sm">
    <div class="container">
        <h1 class="display-6">Meja Nomor: <span class="fw-bold">{{ session('table_name', session('table_id')) }}</span></h1>
        <p class="lead">Pesanan akan dikirim ke meja ini. Selamat memilih!</p>
    </div>
</header>

@if (session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@if (session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif


<section id="menu-list" class="container py-5">
    
    @forelse($categories as $category)
        @if($category->menus->isNotEmpty())
            <h2 class="text-center mb-4 border-bottom pb-2">{{ $category->name }}</h2>
            <div class="row">
                @foreach($category->menus as $menu)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 @if($menu->status != 'tersedia') menu-grayscale @endif">
                            
                            @if($menu->image_path)
                                <img src="{{ asset('storage/' . $menu->image_path) }}" class="card-img-top-menu" alt="{{ $menu->name }}">
                            @else
                                <img src="https://placehold.co/400x200/e9ecef/6c757d?text=Menu" class="card-img-top-menu" alt="Tidak ada gambar">
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p class="card-text text-muted mb-2">
                                    {{ $menu->description ?? 'Deskripsi menu tidak tersedia.' }}
                                </p>
                                <h6 class="text-danger fw-bold mt-auto">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </h6>
                                
                                @if($menu->status == 'tersedia')
                                    <form action="{{ route('client.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="quantity" value="1"> 
                                        
                                        <button type="submit" class="btn btn-success mt-2 w-100">
                                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary mt-2 w-100" disabled>
                                        <i class="bi bi-x-circle"></i> Menu Tidak Tersedia
                                    </button>
                                @endif
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @empty
        @endforelse
    @if($uncategorizedMenus->isNotEmpty())
        <h2 class="text-center mb-4 border-bottom pb-2">Menu Lainnya</h2>
        <div class="row">
            @foreach($uncategorizedMenus as $menu)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100 @if($menu->status != 'tersedia') menu-grayscale @endif">
                        <div class="card-body d-flex flex-column">
                            @if($menu->status == 'tersedia')
                                <form action="{{ route('client.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <input type="hidden" name="quantity" value="1"> 
                                    <button type="submit" class="btn btn-success mt-2 w-100">
                                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary mt-2 w-100" disabled>
                                    <i class="bi bi-x-circle"></i> Menu Tidak Tersedia
                                </button>
                            @endif
                            </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    </section>
@endsection