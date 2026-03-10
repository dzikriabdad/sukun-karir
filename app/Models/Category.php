<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Lowongan (1 Kategori punya banyak Lowongan)
    public function lowongans()
    {
        return $this->hasMany(Lowongan::class);
    }
}