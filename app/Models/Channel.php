<?php

namespace App\Models;

use App\Enums\ChannelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    protected $table = 'channels';
    protected $primaryKey = 'channel_id';

    protected $fillable = [
        'channel_name',
        'avatar',
        'type',
        'credentials',
        'is_enabled',
    ];

    protected $guarded = ['company_id'];
    protected $hidden = ['credentials'];

    protected $casts = [
        'type'       => ChannelType::class,
        'is_enabled' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'channel_id', 'channel_id');
    }
}
