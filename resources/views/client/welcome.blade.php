@extends('client.layouts.app')

@section('title', 'Selamat Datang!')

@section('content')
<div class="container text-center py-5" style="min-height: 70vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            
            <h1 class="display-5 text-success mb-4">Selamat Datang di Dapoer Katendjo!</h1>
            
            <div class="card shadow-sm p-4 bg-light">
                <h3 class="card-title mb-3">Pemesanan Hanya Melalui QR Code</h3>
                <p class="lead">Untuk memulai pemesanan, silakan pindai <strong>QR Code</strong> yang tersedia di meja Anda.</p>
                <i class="bi bi-qr-code-scan display-1 text-secondary my-4"></i>
                <p class="text-muted">Ini akan memastikan pesanan Anda terkirim ke nomor meja yang tepat.</p>
                
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
            </div>

            <p class="mt-4 text-small">
                Untuk pemesanan <strong>Take Away</strong>, silakan hubungi Kasir kami.
            </p>
        </div>
    </div>
</div>
@endsection