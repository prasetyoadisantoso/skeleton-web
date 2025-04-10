<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->uuid('post_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->foreign('post_id')
                ->constrained('post_id_category')
                ->references('id')
                ->on('posts')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('category_id')
                ->constrained('category_id_post')
                ->references('id')
                ->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('category_post');
    }
};
