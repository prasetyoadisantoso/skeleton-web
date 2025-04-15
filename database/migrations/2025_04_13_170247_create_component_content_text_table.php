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
        Schema::create('component_content_text', function (Blueprint $table) {
            $table->uuid('component_id');
            $table->uuid('content_text_id');
            $table->unsignedInteger('order')->default(0); // Kolom untuk urutan
            $table->timestamps(); // Opsional

            // Foreign Keys
            $table->foreign('component_id')
                  ->references('id')
                  ->on('components')
                  ->onDelete('cascade');

            $table->foreign('content_text_id')
                  ->references('id')
                  ->on('content_texts')
                  ->onDelete('cascade');

            // Primary Key (Composite)
            $table->primary(['component_id', 'content_text_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_content_text');
    }
};
