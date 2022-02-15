<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'show_ad',
        'ad_per_minute',
        'allowed_ad_per_month',
        'status'
    ];
}
