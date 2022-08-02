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
        'abuse_type_id',
        'status',
        'address_id'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function abuseType()
    {
        return $this->belongsTo(AbuseType::class, 'abuse_types_id','id');
    }

    public function gbvCenter()
    {
        return $this->belongsTo(GbvCenter::class, 'gbv_center', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
