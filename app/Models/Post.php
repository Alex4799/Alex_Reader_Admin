<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'Title',
        'user_id',
        'category_id',
        'playlist_id',
        'content',
        'image',
        'view_count',

    ];
}
