<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'ad_type',
        'image',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
     public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function adType()
    {
        return $this->belongsTo(AdType::class);
    }
    
}
