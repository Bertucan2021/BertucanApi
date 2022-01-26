<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'url',
        'type',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
