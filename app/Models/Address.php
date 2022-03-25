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
    public function user()
    {
        return $this->hasOne(User::class,'address_id');
    }
    public function company()
    {
        return $this->hasOne(Company::class,'address_id');
    }
    public function gbvcenter()
    {
        return $this->hasOne(GBVCenter::class,'address_id');
    }
}
