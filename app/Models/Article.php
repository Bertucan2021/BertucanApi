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
        'status',
        'language'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'article_by', 'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'item_id');
    }
}
