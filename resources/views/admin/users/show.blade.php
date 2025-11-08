@extends('admin.layouts.app')

@section('title', 'Riwayat Pesanan: ' . $user->name)

@section('content')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Daftar User</a>

<h1 class="mb-4">Riwayat Pesanan: {{ $user->name }}</h1>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title">Detail Pelanggan</h5>
        <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="mb-0"><strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d M Y') }}</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">
        <i class="bi bi-clock-history me-2"></i> Daftar Riwayat Pesanan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @if($order->order_type == 'dine_in')
                                    <span class="badge bg-primary">Dine-In</span>
                                @else
                                    <span class="badge bg-info">Take-Away</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($order->is_paid)
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="bi bi-search"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Pelanggan ini belum memiliki riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection