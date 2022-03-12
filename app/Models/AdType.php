<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'minimum_price',
        'current_no_ads',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function ad()
    {
        return $this->hasOne(Ad::class,'ad_type');
    }
}
