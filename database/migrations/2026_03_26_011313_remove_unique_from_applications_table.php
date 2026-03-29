<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('applications', function (Blueprint $table) {
                // Pakai array biar Laravel nebak namanya otomatis di laptop siapapun
                $table->dropUnique(['user_id', 'lowongan_id']); 
            });
        } catch (\Exception $e) {
            // Kalau di laptop lu udah dihapus manual, errornya bakal ditangkep di sini 
            // dan diabaikan. Jadi terminal lu bakal tetep hijau dan aman sentosa!
        }
    }

    public function down(): void
    {
        try {
            Schema::table('applications', function (Blueprint $table) {
                $table->unique(['user_id', 'lowongan_id']);
            });
        } catch (\Exception $e) {
            // Abaikan kalau gagal rollback
        }
    }
};