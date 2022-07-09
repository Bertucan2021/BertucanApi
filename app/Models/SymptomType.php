<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymptomType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function symptomLog()
    {
        return $this->hasMany(symptomLog::class,'symptom_type_id');
    }
}
