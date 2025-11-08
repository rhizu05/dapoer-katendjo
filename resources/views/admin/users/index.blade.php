@extends('admin.layouts.app')

@section('title', 'Kelola User (Pelanggan)')

@section('content')
<h1 class="mb-4">Kelola User (Pelanggan)</h1>
<p class="lead">Daftar akun pelanggan yang terdaftar di sistem.</p>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Total Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->orders_count }} Pesanan</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Lihat Riwayat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pelanggan yang mendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection