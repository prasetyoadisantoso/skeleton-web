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
        Schema::create('meta_category', function (Blueprint $table) {
            $table->uuid('category_id')->nullable();
            $table->uuid('meta_id')->nullable();
            $table->foreign('category_id')
                ->constrained('category_id_meta')
                ->references('id')
                ->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('meta_id')
                ->constrained('meta_id_category')
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
        Schema::dropIfExists('meta_category');
    }
};
