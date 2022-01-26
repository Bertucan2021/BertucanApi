<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'city',
        'latitude',
        'longitude',
        'type',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
