<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            // Menggunakan UUID sebagai primary key
            $table->uuid('id')->primary();

            // Kolom untuk nama komponen, wajib diisi
            $table->string('name');

            // Kolom untuk deskripsi, bisa kosong (nullable)
            $table->text('description')->nullable();

            // Kolom untuk status aktif/tidak aktif, defaultnya true (aktif)
            $table->boolean('is_active')->default(true);

            // Kolom standar created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel 'components' jika migration di-rollback
        Schema::dropIfExists('components');
    }
};
