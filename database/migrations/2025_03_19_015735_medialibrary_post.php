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
        Schema::create('medialibrary_post', function (Blueprint $table) {
            $table->uuid('post_id'); // Mengganti post_id dengan user_id
            $table->uuid('media_library_id');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('media_library_id')->references('id')->on('media_libraries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medialibrary_post');
    }
};
