<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $table = 'channels';
    protected $primaryKey = 'channel_id';

    protected $fillable = [
        'company_id',
        'provider_type_id',
        'channel_name',
        'credentials',
        'is_active',
    ];

    protected $hidden = ['credentials'];

    protected $casts = [
        'credentials' => 'array',
        'is_active'   => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function providerType(): BelongsTo
    {
        return $this->belongsTo(ChannelProviderType::class, 'provider_type_id', 'provider_type_id');
    }
}
