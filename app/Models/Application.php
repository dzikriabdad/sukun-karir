<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // Buka gembok mass assignment
    protected $guarded = [];

    /**
     * Relasi ke model Lowongan
     * Karena di database kamu kolomnya bernama 'lowongan_id'
     */
    public function lowongan()
    {
        // Menghubungkan lowongan_id di tabel applications ke tabel lowongans
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    /**
     * Relasi ke model User
     * Agar kita bisa tahu siapa pelamarnya
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}