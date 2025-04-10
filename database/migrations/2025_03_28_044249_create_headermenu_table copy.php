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
        Schema::create('headermenus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Nama menu (misalnya "Menu Utama", "Footer Menu")
            $table->string('label'); // Label yang ditampilkan di menu
            $table->string('url')->nullable(); // URL menu, bisa eksternal atau internal
            $table->string('icon')->nullable(); // Class icon (misalnya FontAwesome)
            $table->uuid('parent_id')->nullable(); // ID menu induk (untuk membuat hierarki)
            $table->integer('order')->default(0); // Urutan menu
            $table->string('target')->nullable(); // _self, _blank, dll.
            $table->boolean('is_active')->default(true); // Apakah menu aktif atau tidak
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('headermenus')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headermenus');
    }
};
