<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'body', 'excerpt', 'min_to_read', 'is_published', 'image_path'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }
}
