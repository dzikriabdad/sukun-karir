<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            // Cek dan buat kolom start_date jika belum ada
            if (!Schema::hasColumn('lowongans', 'start_date')) {
                $table->date('start_date')->nullable()->after('location');
            }
            
            // Cek dan buat kolom deadline jika belum ada
            if (!Schema::hasColumn('lowongans', 'deadline')) {
                $table->date('deadline')->nullable()->after('start_date');
            }
        });
    }

    public function down()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            if (Schema::hasColumn('lowongans', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('lowongans', 'deadline')) {
                $table->dropColumn('deadline');
            }
        });
    }
};