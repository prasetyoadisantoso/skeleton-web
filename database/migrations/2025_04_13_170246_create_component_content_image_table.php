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
        Schema::create('component_content_image', function (Blueprint $table) {
            $table->uuid('component_id');
            $table->uuid('content_image_id');
            $table->unsignedInteger('order')->default(0); // Kolom untuk urutan
            $table->timestamps(); // Opsional, jika ingin melacak kapan relasi dibuat/diupdate

            // Foreign Keys
            $table->foreign('component_id')
                  ->references('id')
                  ->on('components')
                  ->onDelete('cascade'); // Jika Component dihapus, relasi ini ikut terhapus

            $table->foreign('content_image_id')
                  ->references('id')
                  ->on('content_images')
                  ->onDelete('cascade'); // Jika ContentImage dihapus, relasi ini ikut terhapus

            // Primary Key (Composite)
            $table->primary(['component_id', 'content_image_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_content_image');
    }
};
