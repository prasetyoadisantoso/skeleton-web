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
        Schema::create('component_section', function (Blueprint $table) {
            $table->id(); // Atau bisa juga UUID jika diperlukan
            // Foreign key ke sections menggunakan UUID
            $table->foreignUuid('section_id')->constrained('sections')->onDelete('cascade');
            // Foreign key ke components menggunakan UUID (sesuai konteks ComponentController)
            $table->foreignUuid('component_id')->constrained('components')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps(); // Optional

            $table->unique(['section_id', 'component_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_section');
    }
};
