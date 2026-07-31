<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Mengubah tipe data dari string (varchar) menjadi text
            $table->text('commitment')->change();
        });
    }

    public function down()

    {
        Schema::table('applications', function (Blueprint $table) {
            // Kembalikan ke string (varchar) jika di-rollback
            $table->string('commitment', 255)->change(); 
        });
    }
};