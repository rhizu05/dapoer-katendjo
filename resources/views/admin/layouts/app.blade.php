<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dapoer Katendjo | @yield('title')</title>
    
    <!-- Link CSS (Dari kode 'lama' Anda yang berfungsi) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        #sidebar {
            width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        #content {
            min-height: 100vh;
        }
    </style>
    
    <!-- TAMBAHAN BARU: Diperlukan untuk Alpine.js (Fitur Take-Away) -->
    @stack('scripts')
</head>
<body>
    <div class="d-flex" id="wrapper">
        
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        
        <!-- Page Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column w-100">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                    <a class="navbar-brand ms-3" href="#">Dashboard</a>
                    <div class="ms-auto">
                        
                        <!-- PERUBAHAN DI SINI: Dibuat Dinamis -->
                        @auth('admin')
                            <span class="navbar-text me-3">Halo, {{ auth('admin')->user()->name }}!</span>
                            <!-- Form Logout Fungsional -->
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        @else
                            <!-- Fallback jika belum login -->
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                        @endauth
                        <!-- AKHIR PERUBAHAN -->
                        
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div id="content" class="p-4">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="bg-light py-3 border-top mt-auto">
                <div class="container-fluid text-center">
                    <small>&copy; 2025 Dapoer Katendjo Admin</small>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Script JS (Dari kode 'lama' Anda yang berfungsi) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript sederhana untuk toggle sidebar di mobile
        document.getElementById("sidebarToggle").onclick = function() {
            document.getElementById("wrapper").classList.toggle("toggled");
        };
    </script>
</body>
</html>