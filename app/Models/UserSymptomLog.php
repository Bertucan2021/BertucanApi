<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSymptomLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'symptom_log'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function symptomLog()
    {
        return $this->belongsTo(SymptomLog::class);
    }
}
