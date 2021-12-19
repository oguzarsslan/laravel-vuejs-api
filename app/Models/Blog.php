<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category',
        'seen',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'blog_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'blog_id');
    }
}
