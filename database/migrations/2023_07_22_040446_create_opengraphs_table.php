<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opengraphs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('og_title');
            $table->text('og_description')->nullable();
            $table->string('og_type')->default('article');
            $table->string('og_url')->nullable();
            $table->uuid('og_image_id')->nullable();
            $table->foreign('og_image_id')->references('id')->on('media_libraries')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opengraphs');
    }
};
