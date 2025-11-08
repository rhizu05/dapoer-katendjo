@extends('client.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Keranjang Belanja Anda</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if (count($cartItems) > 0)
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['image_path'] ? asset('storage/' . $item['image_path']) : 'https://placehold.co/100x100?text=Menu' }}" 
                                                 alt="{{ $item['name'] }}" class="img-thumbnail me-3" style="width: 80px;">
                                            <strong>{{ $item['name'] }}</strong>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item['price']) }}</td>
                                    <td>
                                        <form action="{{ route('client.cart.update', $item['menu_id']) }}" method="POST" class="d-flex">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" class="form-control form-control-sm" style="width: 70px;" min="1">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2" title="Update Jumlah">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td><strong>Rp {{ number_format($item['subtotal']) }}</strong></td>
                                    <td>
                                        <a href="{{ route('client.cart.remove', $item['menu_id']) }}" class="btn btn-sm btn-outline-danger" title="Hapus Item" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>
                
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <h3 class="d-flex justify-content-between">
                            <span>Total:</span>
                            <span class="text-danger fw-bold">Rp {{ number_format($totalAmount) }}</span>
                        </h3>
                        <p class="text-muted text-end">Meja Anda: {{ session('table_name', 'N/A') }}</I>
                        <hr>
                        <p>Pilih Metode Pembayaran:</p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning btn-lg"><i class="bi bi-qr-code me-2"></i> Bayar dengan QRIS (Otomatis)</button>
                            <button class="btn btn-secondary btn-lg"><i class="bi bi-cash-coin me-2"></i> Bayar di Kasir (Manual)</button>
                        </div>
                    </div>
                </div>

            @else
                <div class="text-center p-4">
                    <h5>Keranjang Anda masih kosong.</h5>
                    <a href="{{ route('client.menu.list') }}" class="btn btn-primary mt-3">Kembali ke Menu</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection