<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'image', 'published_at', 'comments_count', 'is_published'
    ];
 
    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];
}