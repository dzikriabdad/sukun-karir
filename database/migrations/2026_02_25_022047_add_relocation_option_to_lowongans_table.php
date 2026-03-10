<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom.
     */
    public function up()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            // 1. Menambahkan kolom start_date jika belum ada
            if (!Schema::hasColumn('lowongans', 'start_date')) {
                $table->date('start_date')->nullable()->after('location');
            }

            // 2. Menambahkan kolom deadline (end_date) jika belum ada
            if (!Schema::hasColumn('lowongans', 'deadline')) {
                $table->date('deadline')->nullable()->after('start_date');
            }

            // 3. Menambahkan opsi relokasi (Fitur Baru)
            // Default 'true' (1) agar lowongan lama otomatis menanyakan relokasi
            if (!Schema::hasColumn('lowongans', 'is_relocation_asked')) {
                $table->boolean('is_relocation_asked')->default(true)->after('status');
            }
        });
    }

    /**
     * Batalkan migration (Rollback).
     */
    public function down()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'deadline', 'is_relocation_asked']);
        });
    }
};