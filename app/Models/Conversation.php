<?php

namespace App\Models;

use App\Enums\ConversationStatus;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    protected $primaryKey = 'conversation_id';

    protected $fillable = [
        'contact_id',
        'assigner_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'status'          => ConversationStatus::class,
        'last_message_at' => 'datetime',
    ];
}
