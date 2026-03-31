<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'message_id';

    protected $fillable = [
        'conversation_id',
        'content',
        'type',
        'external_id',
    ];

    protected $casts = [
        'type' => MessageType::class,
    ];
}
