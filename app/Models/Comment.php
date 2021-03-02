<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public const MAX_LEVEL = 3;

    protected $fillable = [
        'body',
        'level',
        'parent_id',
        'username',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'desc')->limit(5);
    }
}
