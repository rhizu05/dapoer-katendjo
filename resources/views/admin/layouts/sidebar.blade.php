<div class="bg-dark text-white border-right" id="sidebar">
    <div class="sidebar-heading p-4 border-bottom border-secondary">
        <i class="bi bi-gear-fill me-2"></i> <strong>ADMIN PANEL</strong>
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        
        <div class="list-group-item bg-secondary text-white fw-bold">KELOLA PESANAN</div>
        <a href="{{ route('admin.orders.dinein') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5"><i class="bi bi-table me-2"></i> Dine-In</a>
        <a href="{{ route('admin.orders.takeaway') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5"><i class="bi bi-bag me-2"></i> Take-Away (Input)</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-bell me-2"></i> Notifikasi Pembayaran</a>
        

        
        <div class="list-group-item bg-secondary text-white fw-bold">DATA MASTER</div>
        <a href="{{ route('admin.menu.index') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-cup-hot me-2"></i> Kelola Menu</a>
        <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5"><i class="bi bi-tags me-2"></i> Kelola Kategori</a>
        <a href="{{ route('admin.tables.index') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-qr-code-scan me-2"></i> Kelola Meja & QR</a>
        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-people me-2"></i> Kelola User</a>
        
        <div class="list-group-item bg-secondary text-white fw-bold">LAPORAN</div>
        <a href="{{ route('admin.reports.sales') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="bi bi-graph-up me-2"></i> Laporan Penjualan</a>
    </div>
</div>