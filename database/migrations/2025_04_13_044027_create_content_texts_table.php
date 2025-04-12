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
        Schema::create('content_texts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Enum untuk tipe teks
            $table->enum('type', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'paragraph'])->default('paragraph');
            $table->text('content'); // Kolom untuk menyimpan teks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_texts');
    }
};
