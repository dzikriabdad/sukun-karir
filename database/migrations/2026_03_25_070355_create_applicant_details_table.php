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
    Schema::create('applicant_details', function (Blueprint $table) {
        $table->id();
        // Ini kunci gembok penyambung ke tabel users
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        // Biodata pelamar
        $table->string('nik', 16)->nullable();
        $table->string('phone_number', 15)->nullable();
        $table->text('address')->nullable();
        $table->string('last_education')->nullable();
        
        // Tempat nyimpen nama file upload
        $table->string('cv_path')->nullable(); 
        $table->string('photo_path')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_details');
    }
};
