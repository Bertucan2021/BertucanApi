<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'address_id',
        'membership_id',
        'phone_number'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
