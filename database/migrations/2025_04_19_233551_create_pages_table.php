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
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->uuid('layout_id')->nullable();
            $table->uuid('meta_id')->nullable();
            $table->uuid('opengraph_id')->nullable();
            $table->uuid('canonical_id')->nullable();
            $table->uuid('schemadata_id')->nullable();
            $table->timestamps();

            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('set null');
            $table->foreign('meta_id')->references('id')->on('metas')->onDelete('set null');
            $table->foreign('opengraph_id')->references('id')->on('opengraphs')->onDelete('set null');
            $table->foreign('canonical_id')->references('id')->on('canonicals')->onDelete('set null');
            $table->foreign('schemadata_id')->references('id')->on('schemadatas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
