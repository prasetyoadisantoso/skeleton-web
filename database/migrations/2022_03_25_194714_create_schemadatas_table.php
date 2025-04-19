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
        Schema::create('schemadatas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('schema_name');
            $table->string('schema_type');
            $table->longText('schema_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemadatas');
    }
};
