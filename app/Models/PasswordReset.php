<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [

    ];


    public function user()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
