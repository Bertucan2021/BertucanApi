<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'startDate',
        'endDate',
        'pregnancyDate',
        'phaseChange',
        'user_id',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
