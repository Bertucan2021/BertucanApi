<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'reported_by',
        'abuse_type',
        'status',
        'address_id'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
