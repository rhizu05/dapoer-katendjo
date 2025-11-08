@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan Dine-In')

@section('content')
<h1 class="mb-4">Daftar Pesanan Dine-In</h1>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nomor Pesanan</th>
                <th>Meja</th>
                <th>Status Pembayaran</th>
                <th>Status Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ORD-1021</td>
                <td>A05</td> <td><span class="badge bg-warning text-dark">PENDING</span></td> <td><span class="badge bg-secondary">MENUNGGU</span></td> <td>
                    <a href="#" class="btn btn-sm btn-success me-2"><i class="bi bi-check-circle"></i> Konfirmasi Bayar</a>
                    <a href="#" class="btn btn-sm btn-info me-2"><i class="bi bi-search"></i> Detail</a>
                    <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Batalkan</a>
                </td>
            </tr>
             <tr>
                <td>ORD-1020</td>
                <td>B12</td> 
                <td><span class="badge bg-success">LUNAS</span></td> 
                <td><span class="badge bg-primary">DIPROSES</span></td> 
                <td>
                    <a href="#" class="btn btn-sm btn-primary me-2"><i class="bi bi-printer"></i> Cetak Struk</a>
                    <a href="#" class="btn btn-sm btn-info me-2"><i class="bi bi-search"></i> Detail</a>
                </td>
            </tr>
            </tbody>
    </table>
</div>
@endsection