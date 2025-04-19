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
        Schema::create('layout_section', function (Blueprint $table) {
            $table->uuid('layout_id');
            $table->uuid('section_id');
            $table->enum('location', ['main', 'sidebar'])->default('main');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->primary(['layout_id', 'section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layout_section');
    }
};
