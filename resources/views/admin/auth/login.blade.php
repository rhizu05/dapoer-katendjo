<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Dapoer Katendjo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card">
        <div class="text-center mb-4">
            <i class="bi bi-shop display-4 text-primary"></i>
            <h1 class="h3 mb-0 fw-bold mt-2">ADMIN / KASIR LOGIN</h1>
            <p class="text-muted">Dapoer Katendjo Management System</p>
        </div>
        
        <!-- Form Login diarahkan ke rute POST yang sudah didefinisikan di routes/web.php -->
        <form method="POST" action="{{ route('login') }}">
            @csrf 
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    Login gagal. Silakan periksa kembali email dan kata sandi Anda.
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Masukkan email" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Masukkan kata sandi" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i> LOGIN
                </button>
            </div>
            
        </form>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
