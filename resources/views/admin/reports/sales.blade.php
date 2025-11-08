@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<h1 class="mb-4">Laporan Penjualan</h1>
<p class="lead">Ini adalah halaman untuk melihat laporan penjualan.</p>

<!-- Tombol Export (Contoh) -->
<button class="btn btn-primary mb-3"><i class="bi bi-file-earmark-excel"></i> Export ke Excel</button>
<button class="btn btn-danger mb-3"><i class="bi bi-file-earmark-pdf"></i> Export ke PDF</button>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Ringkasan Penjualan</h5>
        <p>Total Penjualan Hari Ini: Rp 500.000</p>
    </div>
</div>

@endsection
