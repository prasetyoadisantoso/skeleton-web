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
        Schema::create('canonical_post', function (Blueprint $table) {
            $table->uuid('post_id')->nullable();
            $table->uuid('canonical_id')->nullable();
            $table->foreign('post_id')
                ->constrained('post_id_canonical')
                ->references('id')
                ->on('posts')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('canonical_id')
                ->constrained('canonical_id_post')
                ->references('id')
                ->on('canonicals')
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
        Schema::dropIfExists('canonical_post');
    }
};
