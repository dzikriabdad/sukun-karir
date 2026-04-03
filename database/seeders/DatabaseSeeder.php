<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // 1. WAJIB TAMBAHKAN INI UNTUK FITUR SLUG

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin (HRD)
        User::create([
            'name' => 'Admin HRD',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
        ]);

        // Membuat Akun Pelamar (Untuk Testing)
        User::create([
            'name' => 'contoh (Pelamar)',
            'email' => 'pelamar@gmail.com',
            'password' => Hash::make('password123'), 
            'role' => 'pelamar',
        ]);

        // Membuat Data Kategori Pekerjaan
        $categories = [
            'Technology',
            'Marketing',
            'Finance',
            'Logistics & Supply Chain',
        ];

        // 2. KITA UBAH LOOPING-NYA SUPAYA OTOMATIS BIKIN SLUG
        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName) // Ini yang akan mengatasi error 1364!
            ]);
        }
    }
}