<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbuseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function report()
    {
        return $this->hasMany(Report::class, 'abuse_types_id', 'id');
    }
}
