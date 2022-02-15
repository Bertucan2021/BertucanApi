<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GBVCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'phone_number',
        'address_id',
        'membership_id',
        'license',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
