<?php

namespace App\Models;

use App\Enums\ConversationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $table = 'conversations';
    protected $primaryKey = 'conversation_id';

    protected $fillable = [
        'contact_id',
        'channel_id',
        'external_id',
        'status',
    ];

    protected $casts = [
        'status' => ConversationStatus::class,
    ];

    protected $attributes = [
        'status' => ConversationStatus::PENDING,
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'channel_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'contact_id');
    }
}
