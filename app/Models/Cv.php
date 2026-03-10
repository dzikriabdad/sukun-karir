<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $table = 'cvs'; 

    // Gunakan fillable saja agar tidak bentrok dengan guarded
   protected $fillable = [
    'user_id', 'full_name', 'identity_number', 'phone_number', 
    'gender', 'religion', 'marital_status', 'place_of_birth', 
    'date_of_birth', 'address', 'last_education', 'university', 
    'major', 'gpa', 'experience', 'file_cv'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}