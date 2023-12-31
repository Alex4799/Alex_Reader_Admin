<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayListItem extends Model
{
    use HasFactory;

    protected $fillable=[
        'playlist_id',
        'post_id',
    ];
}
