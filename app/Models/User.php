<?php

namespace App\Models;

use App\Models\Concerns\HasPermissions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasPermissions;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'company_id',
        'username',
        'email',
        'password',
        'avatar',
        'phone',
        'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'      => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search,
            fn($q) => $q->where(fn($q) => $q->where('username', 'ilike', "%$search%")->orWhere('email', 'ilike', "%$search%"))
        );
    }
}
