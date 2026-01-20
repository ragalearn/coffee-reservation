<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Relasi ke users
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke categories
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('people_count');

            // ⬇️ INI YANG SEBELUMNYA HILANG
            $table->string('phone_number')->nullable();
            $table->text('special_request')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'rejected',
                'cancelled',
                'completed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
