<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('media_library_id')->nullable(); // Foreign key ke media_libraries
            $table->string('alt_text')->nullable(); // Teks alternatif untuk gambar
            $table->string('name'); // Nama gambar
            $table->text('caption')->nullable(); // Keterangan gambar (opsional)
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('media_library_id')
                  ->references('id')
                  ->on('media_libraries')
                  ->onDelete('cascade'); // Jika MediaLibrary dihapus, ContentImage ikut terhapus
            // ->onDelete('set null'); // Alternatif: Jika MediaLibrary dihapus, set media_library_id jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_images');
    }
};
