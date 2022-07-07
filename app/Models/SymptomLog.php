<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymptomLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'symptom_description',
        'symptom_type_id'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
    public function symptomType()
    {
        return $this->belongsTo(SymptomType::class);
    }
}
