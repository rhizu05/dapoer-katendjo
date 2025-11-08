@extends('client.layouts.app')

@section('title', 'Profil Pelanggan')

@section('content')
    <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            
            <h2 class="text-center mb-4">Pengaturan Akun</h2>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    
                    <img src="https://via.placeholder.com/100" class="rounded-circle mb-3 border border-3 border-secondary" alt="Foto Profil">
                    
                    <h5 class="card-title">Halo, Pengunjung!</h5>
                    <p class="card-text text-muted">Belum Masuk/Daftar</p>
                    
                    <a href="[ROUTE_LOGIN]" class="btn btn-primary w-100 mt-3">
                        Sign In / Daftar
                    </a>
                    
                    </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">
                    Riwayat Pesanan
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pesanan #TK2025001
                        <span class="badge bg-success">Selesai</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pesanan #TK2025002
                        <span class="badge bg-warning text-dark">Dibatalkan</span>
                    </li>
                    <li class="list-group-item text-center">
                        <a href="[ROUTE_RIWAYAT]" class="btn btn-link">Lihat Semua Riwayat</a>
                    </li>
                </ul>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">
                    Pengaturan
                </div>
                <div class="card-body">
                    <label for="languageSelect" class="form-label d-block mb-2">Pilih Bahasa:</label>
                    
                    <select class="form-select" id="languageSelect" onchange="changeLanguage(this.value)">
                        <option value="id" selected>🇮🇩 Bahasa Indonesia</option>
                        <option value="en">🇬🇧 English</option>
                    </select>
                    
                    <script>
                        function changeLanguage(lang) {
                            // Di Laravel, fungsi ini akan melakukan POST request
                            // ke rute yang menyimpan pilihan bahasa ke session atau database.
                            // Contoh: window.location.href = '/language/' + lang;
                            console.log('Mengganti bahasa ke: ' + lang);
                            alert('Simulasi: Bahasa akan diubah menjadi ' + (lang === 'id' ? 'Indonesia' : 'English') + ' setelah refresh halaman.');
                        }
                    </script>
                </div>
            </div>

            <div class="text-center mt-4">
                 <a href="[ROUTE_LOGOUT]" class="btn btn-outline-danger">Sign Out (jika sudah login)</a>
            </div>

        </div>
    </div>
</div>

@endsection