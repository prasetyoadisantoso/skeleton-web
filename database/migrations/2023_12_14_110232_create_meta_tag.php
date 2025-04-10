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
        Schema::create('meta_tag', function (Blueprint $table) {
            $table->uuid('tag_id')->nullable();
            $table->uuid('meta_id')->nullable();
            $table->foreign('tag_id')
                ->constrained('tag_id_meta')
                ->references('id')
                ->on('tags')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('meta_id')
                ->constrained('meta_id_tag')
                ->references('id')
                ->on('metas')
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
        Schema::dropIfExists('meta_tag');
    }
};
