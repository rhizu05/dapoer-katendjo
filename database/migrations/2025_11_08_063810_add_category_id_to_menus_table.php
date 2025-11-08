<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom 'category_id' ke tabel 'menus'.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable() // Boleh null jika ada menu tanpa kategori
                  ->after('status')
                  ->constrained('categories') // Relasi ke tabel 'categories'
                  ->onDelete('set null'); // Jika kategori dihapus, set ID menu ke null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};