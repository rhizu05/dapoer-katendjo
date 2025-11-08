<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- 
          PERBAIKAN DI SINI: 
          Tautan Brand/Logo sekarang juga mengarah ke menu meja yang sedang aktif.
        -->
        <a class="navbar-brand" href="{{ session('table_id') ? route('client.menu.dinein', session('table_id')) : route('welcome') }}">
            Dapoer Katendjo
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <!-- 
                  PERBAIKAN DI SINI: 
                  Tautan 'Menu' sekarang dinamis berdasarkan sesi 'table_id'.
                -->
                <li class="nav-item">
                    <a class="nav-link active" href="{{ session('table_id') ? route('client.menu.dinein', session('table_id')) : route('client.menu.list') }}">
                        Menu
                    </a>
                </li>
                <!-- AKHIR PERBAIKAN -->
                
                <li class="nav-item">
                    <a class="btn btn-warning ms-lg-3 mt-2 mt-lg-0" href="{{ route('client.cart.index') }}">
                        <i class="bi bi-cart-fill"></i> Keranjang 
                        <!-- Hitung jumlah item di keranjang -->
                        <span class="badge bg-danger">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="btn btn-primary ms-lg-2 mt-2 mt-lg-0" href="{{ route('client.profile.index') }}">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>