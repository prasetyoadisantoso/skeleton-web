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
        Schema::create('opengraph_post', function (Blueprint $table) {
            $table->uuid('post_id')->nullable();
            $table->uuid('opengraph_id')->nullable();
            $table->foreign('post_id')
                ->constrained('post_id_opengraph')
                ->references('id')
                ->on('posts')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('opengraph_id')
                ->constrained('opengraph_id_post')
                ->references('id')
                ->on('opengraphs')
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
        Schema::dropIfExists('opengraph_post');
    }
};
