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
        Schema::create('generals', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menambahkan primary key
            $table->string('site_title');
            $table->string('site_tagline');
            $table->string('site_email');
            $table->string('url_address');
            $table->string('copyright');
            $table->string('google_tag');
            $table->string('cookies_concern');
            $table->uuid('site_logo_id')->nullable(); // Foreign key ke media_libraries
            $table->uuid('site_favicon_id')->nullable(); // Foreign key ke media_libraries
            $table->timestamps();

            $table->foreign('site_logo_id')->references('id')->on('media_libraries')->onDelete('set null');
            $table->foreign('site_favicon_id')->references('id')->on('media_libraries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generals');
    }
};
