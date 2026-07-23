<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk memperbesar kapasitas kolom GPA.
     */
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            // Kita ubah ke (5, 2) biar muat angka 100.00 (ijazah sekolah)
            $table->decimal('gpa', 5, 2)->change();
        });
    }

    /**
     * Balikin ke ukuran semula kalau migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            // Balikin ke (3, 2) alias maksimal 9.99
            $table->decimal('gpa', 3, 2)->change();
        });
    }
};