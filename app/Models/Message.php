<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'reply_id',
        'sent_email',
        'receive_email',
        'content',
        'status',
    ];
}
