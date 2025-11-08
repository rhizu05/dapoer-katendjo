<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom user_id (nullable) ke tabel orders.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable() // <-- KUNCI: Boleh null untuk pesanan tamu
                  ->after('table_id')
                  ->constrained('users') // Terhubung ke tabel 'users' (pelanggan)
                  ->onDelete('set null'); // Jika user dihapus, jangan hapus pesanannya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};