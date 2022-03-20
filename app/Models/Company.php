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
        'phone_number',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
    public function media()
    {
        return $this->hasMany(Media::class,'item_id');
    }
}
