@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="mb-4">Dashboard Admin</h1>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-start border-primary border-5 shadow-lg h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Jumlah Pesanan Hari Ini
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">15 Pesanan</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cart-fill fa-2x text-gray-300 display-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-start border-warning border-5 shadow-lg h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Pesanan Sedang Diproses (Dapur)
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">5 Pesanan</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-hourglass-split fa-2x text-gray-300 display-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-start border-danger border-5 shadow-lg h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col me-2">
                        <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                            Notifikasi Pembayaran Pending
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">3 Pesanan</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-credit-card-2-back-fill fa-2x text-gray-300 display-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Aktivitas Penjualan 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <p class="text-center">  </p>
            </div>
        </div>
    </div>
</div>

@endsection