<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'company_id',
        'username',
        'avatar',
        'phone',
        'email'
    ];

    protected $attributes = [
        'username' => 'Новый контакт'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'channel_id', 'channel_id');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }
}
