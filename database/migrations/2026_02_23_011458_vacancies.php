<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lowongans', function (Blueprint $table) {
        $table->id(); 
        
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        
        $table->string('title');
        $table->string('slug')->unique();
        
        // Ini yang ditambahkan dari ERD kamu
        $table->string('experience'); // Bisa pakai string atau text, tergantung panjang isinya
        
        $table->text('description'); // Pengganti 'detail' di ERD
        $table->string('location')->nullable(); // Pengganti 'placement' di ERD
        $table->string('status')->default('aktif'); 
        
        $table->timestamps();
    });
}


public function down(): void
{
    Schema::dropIfExists('lowongans');
}
};