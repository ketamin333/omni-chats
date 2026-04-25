<?php

namespace App\Models;

use App\Enums\ChannelStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $table = 'channels';
    protected $primaryKey = 'channel_id';

    protected $fillable = [
        'company_id',
        'adapter_id',
        'status',
        'channel_name',
        'credentials',
        'settings',
    ];

    protected $hidden = ['credentials'];

    protected $casts = [
        'status'      => ChannelStatus::class,
        'credentials' => 'array',
        'settings'    => 'array',
    ];

    protected $attributes = [
        'status' => ChannelStatus::PENDING,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function adapter(): BelongsTo
    {
        return $this->belongsTo(Adapter::class, 'adapter_id', 'adapter_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'channel_id', 'channel_id');
    }
}
