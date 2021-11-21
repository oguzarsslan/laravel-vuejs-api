<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'image',
    ];

    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}
