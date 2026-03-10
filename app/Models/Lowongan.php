<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $guarded = ['id'];

    // Relasi balik ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi balik ke User (Admin/HRD pembuat lowongan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Lamaran (1 Lowongan dilamar banyak orang)
    public function applications()
    {
        return $this->hasMany(Application::class, 'lowongan_id');
    }
    
    
}
