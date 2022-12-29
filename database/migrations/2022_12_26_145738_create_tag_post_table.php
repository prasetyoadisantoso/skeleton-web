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
        Schema::create('tag_post', function (Blueprint $table) {
            $table->uuid('post_id')->nullable();
            $table->uuid('tag_id')->nullable();
            $table->foreign('post_id')
                ->constrained('post_id_tag')
                ->references('id')
                ->on('posts')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('tag_id')
                ->constrained('tag_id_post')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('tag_post');
    }
};
