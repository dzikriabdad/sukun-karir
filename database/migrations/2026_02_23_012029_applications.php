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
    Schema::create('applications', function (Blueprint $table) {
        $table->id(); // Tidak perlu ->primary() lagi karena id() sudah otomatis primary
        
        // Relasi ke tabel users (pelamar)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Relasi ke tabel lowongans (yang baru saja kamu buat)
        $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
        
        // Data tambahan dari ERD kamu
        $table->text('application_reason')->nullable();
        $table->string('commitment')->nullable();
        $table->string('relocation_ready')->nullable();
        $table->integer('expected_salary')->nullable();
        $table->string('status')->default('pending'); // Biar default-nya 'menunggu'
        
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('applications');
}
};
