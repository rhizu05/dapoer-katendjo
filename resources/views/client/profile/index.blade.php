@extends('client.layouts.app')

@section('title', 'Profil & Pengaturan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            
            <h2 class="text-center mb-4">Pengaturan Akun</h2>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Selamat Datang!</h5>
                    <p class="card-text text-muted">Akses Riwayat Pesanan Anda dengan Login.</p>
                    <a href="#" class="btn btn-primary w-100 mt-3">Sign In / Daftar</a>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">Riwayat Pesanan</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Pesanan #TK2025001 - Selesai</li>
                    <li class="list-group-item text-center">
                        <a href="#" class="btn btn-link">Lihat Semua Riwayat</a>
                    </li>
                </ul>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">Pengaturan Bahasa</div>
                <div class="card-body">
                    <form action="{{ route('client.set.language', ['locale' => 'id']) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ session('locale', 'id') == 'id' ? 'btn-success' : 'btn-outline-secondary' }} w-50">🇮🇩 ID</button>
                    </form>
                    <form action="{{ route('client.set.language', ['locale' => 'en']) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ session('locale') == 'en' ? 'btn-success' : 'btn-outline-secondary' }} w-50">🇬🇧 EN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection