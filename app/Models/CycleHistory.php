<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'notes',
        'changes',
        'user_id'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
