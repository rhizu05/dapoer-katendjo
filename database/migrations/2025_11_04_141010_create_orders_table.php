<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (Membuat tabel 'orders' untuk Dashboard & Fitur B)
     */
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                
                // Relasi ke Meja (untuk Dine-in)
                $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
                
                // Relasi ke Admin (yang memverifikasi/input)
                $table->foreignId('verified_by')->nullable()->constrained('admin_users')->onDelete('set null');

                $table->enum('order_type', ['dine_in', 'take_away'])->default('dine_in');
                $table->string('status')->default('MENUNGGU_PEMBAYARAN'); // e.g., 'DAPUR_QUEUE', 'SELESAI'
                
                $table->boolean('is_paid')->default(false);
                $table->integer('total_amount'); // Total harga pesanan

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
