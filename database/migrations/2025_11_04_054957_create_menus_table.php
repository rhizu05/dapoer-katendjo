<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (Membuat tabel 'menus' untuk Fitur C)
     */
    public function up(): void
    {
        // Cek jika tabel 'menus' belum ada
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('price');
                $table->string('image_path')->nullable();
                $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
