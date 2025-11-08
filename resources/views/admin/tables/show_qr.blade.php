@extends('admin.layouts.app')

@section('title', 'QR Code Meja ' . $table->name)

@section('content')
<style>
    /* CSS untuk menyembunyikan elemen non-cetak saat print */
    @media print {
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Sembunyikan tombol cetak saat mencetak */
        .no-print {
            display: none;
        }
    }
</style>

<div class="text-center" id="print-area">
    <h1 class="mb-4">Meja: <span class="text-danger">{{ $table->name }}</span></h1>
    <p class="lead">Pindai kode ini untuk memesan</p>
    
    <!-- Tampilkan QR Code (SVG) -->
    <div class="my-4">
        {!! $qrCode !!}
    </div>
    
    <p class="text-muted small">URL: {{ $url }}</p>
</div>

<div class="text-center mt-4 no-print">
    <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak QR Code Ini</button>
    <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">Kembali ke Daftar Meja</a>
</div>

@endsection
