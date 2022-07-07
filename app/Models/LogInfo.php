<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_registered',
        'is_logged',
        'token',
        'user_id'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
