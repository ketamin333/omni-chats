<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'company_id',
        'username',
        'phone',
        'email'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'channel_id', 'channel_id');
    }
}
