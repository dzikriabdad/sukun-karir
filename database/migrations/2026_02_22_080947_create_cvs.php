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
        Schema::create('cvs', function (Blueprint $table) {
            // Primary key otomatis (id)
            $table->id(); 
            
            // Relasi ke tabel users (Pelamar) - Cascade delete agar kalau user dihapus, CV-nya ikut terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Pribadi
            $table->string('full_name');
            $table->string('identity_number')->unique()->nullable(); // NIK atau nomor identitas lain
            $table->string('phone_number');
            $table->string('gender');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->text('address'); // Pakai text agar muat alamat lengkap
            
            // Data Pendidikan & Pengalaman
            $table->string('last_education');
            $table->string('university');
            $table->string('major');
            $table->decimal('gpa', 3, 2); // Format IPK (misal: 3.99)
            $table->text('experience'); // Pakai text karena deskripsi pengalaman biasanya panjang
            
            // File Attachment
            $table->string('file_cv'); // Menyimpan nama file atau path file PDF/Doc
            
            // Waktu dibuat & diupdate otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};