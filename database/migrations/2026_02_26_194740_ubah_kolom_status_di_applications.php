<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan perintah migrasi (Up).
     */
    public function up(): void
    {
        // Menggunakan Raw SQL untuk mengubah tipe kolom ENUM menjadi VARCHAR dengan aman
        DB::statement("ALTER TABLE applications MODIFY status VARCHAR(255) DEFAULT 'screening'");
    }

    /**
     * Kembalikan perintah migrasi (Down).
     */
    public function down(): void
    {
        // Jika di-rollback, kembalikan ke ENUM awal (opsional)
        DB::statement("ALTER TABLE applications MODIFY status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending'");
    }
};