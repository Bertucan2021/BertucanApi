<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'phone_number',
        'log_status',
        'birthdate',
        'role',
        'address_id',
        'email_verified_at',
        'membership_id',
        'remember_token'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    protected $hidden = [
        'password',
        
    ];
 
    public function article()
    {
        return $this->hasOne(Article::class,'article_by');
    }
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
