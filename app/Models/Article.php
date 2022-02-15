<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'introduction',
        'icon',
        'body',
        'small_description',
        'article_by',
        'type',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 
}
