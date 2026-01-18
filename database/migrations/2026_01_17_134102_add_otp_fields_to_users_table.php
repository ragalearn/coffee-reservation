<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp_code')->nullable();              // Kode OTP
            $table->timestamp('otp_verified_at')->nullable();   // Waktu berhasil verifikasi
            $table->timestamp('otp_expires_at')->nullable();    // Masa berlaku OTP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'otp_code',
                'otp_verified_at',
                'otp_expires_at',
            ]);
        });
    }
};
