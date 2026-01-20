<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            // TAMBAHAN BARU (Wajib ada agar Seeder tidak error)
            $table->text('description')->nullable(); // Untuk deskripsi suasana
            $table->string('image')->nullable();     // Untuk foto kategori
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};