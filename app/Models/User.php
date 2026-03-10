<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
 protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Wajib ditambahkan!
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // ... kode bawaan Laravel ...

    // Tambahkan fungsi ini di dalam class User
    public function cv()
    {
    // Mengacu ke model Cv (yang mewakili tabel cvs)
    return $this->hasOne(Cv::class, 'user_id');
    }

    // Relasi ke Lamaran (1 Pelamar bisa melamar banyak lowongan)
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Relasi ke Lowongan (Khusus Admin/HRD yang memposting banyak lowongan)
    public function lowongans()
    {
        return $this->hasMany(Lowongan::class);
    }
    
   
}
