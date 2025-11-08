<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (Menambahkan kolom 'notes' ke tabel order_details)
     */
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            // Kebutuhan: Kolom catatan
            $table->string('notes')->nullable()->after('price'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};