<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blog_id',
        'favorite',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'user_id', Auth::id());
    }
}
