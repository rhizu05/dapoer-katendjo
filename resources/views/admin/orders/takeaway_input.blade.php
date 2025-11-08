@extends('admin.layouts.app')

@section('title', 'Input Pesanan Take-Away')

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function posSystem() {
            return {
                cart: [],
                
                // Fungsi ini dipanggil dari DAFTAR MENU (kiri)
                addItem(menu) {
                    const existingItem = this.cart.find(item => item.id === menu.id);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        // Menambahkan 'notes' saat item baru masuk
                        this.cart.push({
                            id: menu.id,
                            name: menu.name,
                            price: menu.price,
                            quantity: 1,
                            notes: '' // <-- Properti notes
                        });
                    }
                },
                
                // Fungsi ini dipanggil dari tombol (+) KERANJANG
                increaseQuantity(menuId) {
                    const item = this.cart.find(item => item.id === menuId);
                    if (item) {
                        item.quantity++;
                    }
                },
                
                // Fungsi ini dipanggil dari tombol (-) KERANJANG
                decreaseQuantity(menuId) {
                    const item = this.cart.find(item => item.id === menuId);
                    if (item) {
                        item.quantity--;
                        if (item.quantity < 1) {
                            this.removeItem(menuId); // Hapus jika jadi 0
                        }
                    }
                },
                
                // Hapus item dari keranjang (dipanggil tombol sampah)
                removeItem(menuId) {
                    this.cart = this.cart.filter(item => item.id !== menuId);
                },
                
                // Hitung total (getter)
                get total() {
                    return this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                },
                
                // Format mata uang
                formatCurrency(value) {
                    return new Intl.NumberFormat('id-ID').format(value);
                }
            };
        }
    </script>
@endpush

@section('content')
<h1 class="mb-4">Input Pesanan Take-Away (POS)</h1>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div x-data="posSystem()">
    <form action="{{ route('admin.orders.takeaway.store') }}" method="POST">
        @csrf
        <input type="hidden" name="cart" :value="JSON.stringify(cart)">

        <div class="row">
            
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Pilih Menu (Hanya yang Tersedia)</div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        
                        @forelse ($categories as $category)
                            @if($category->menus->isNotEmpty())
                                <h5 class="mt-3 border-bottom pb-2">{{ $category->name }}</h5>
                                <div class="list-group">
                                    @foreach ($category->menus as $menu)
                                        <button type="button" 
                                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                                @click="addItem({{ $menu }})">
                                            {{ $menu->name }}
                                            <span class="text-danger fw-bold">Rp {{ number_format($menu->price) }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @empty
                            @endforelse

                        @if($uncategorizedMenus->isNotEmpty())
                            <h5 class="mt-3 border-bottom pb-2">Menu Lainnya</h5>
                            <div class="list-group">
                                @foreach ($uncategorizedMenus as $menu)
                                    <button type="button" 
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                            @click="addItem({{ $menu }})">
                                        {{ $menu->name }}
                                        <span class="text-danger fw-bold">Rp {{ number_format($menu->price) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header fw-bold">Detail Pesanan & Pembayaran</div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan (Opsional)</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="cth: Budi">
                        </div>
                        
                        <hr>
                        
                        <h6>Keranjang Pesanan</h6>
                        <div style="max-height: 250px; overflow-y: auto;">
                            <ul class="list-group">
                                <template x-for="item in cart" :key="item.id">
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span x-text="item.name"></span><br>
                                                <small class="text-muted">Rp <span x-text="formatCurrency(item.price)"></span></small>
                                            </div>
                                            
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="decreaseQuantity(item.id)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                
                                                <span class="mx-2 fw-bold" x-text="item.quantity" style="min-width: 20px; text-align: center;"></span>
                                                
                                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="increaseQuantity(item.id)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                                
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-3" @click="removeItem(item.id)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="text" x-model="item.notes" placeholder="Catatan (cth: pedas, tidak pakai sayur)" class="form-control form-control-sm mt-2">
                                    </li>
                                </template>
                                
                                <li class="list-group-item text-center" x-show="cart.length === 0">
                                    <small class="text-muted">Keranjang masih kosong...</small>
                                </li>
                            </ul>
                        </div>
                        
                        <h4 class="mt-3 d-flex justify-content-between">
                            Total: 
                            <span class="text-danger fw-bold">Rp <span x-text="formatCurrency(total)"></span></span>
                        </h4>
                        
                        <hr>
                        
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="payment_method" required>
                                <option value="Tunai">Tunai</option>
                                <option value="Debit/Kredit">Debit/Kredit</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 mt-3" :disabled="cart.length === 0">
                            <i class="bi bi-check-lg"></i> Simpan & Kirim ke Koki
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection