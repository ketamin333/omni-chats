<?php

namespace App\Models;

use App\Enums\PermissionSlug;
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
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'company_id',
        'username',
        'email',
        'password',
        'avatar',
        'phone',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'      => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : null;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function hasPermission(PermissionSlug|string $slug): bool
    {
        if (!$this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        $value = $slug instanceof PermissionSlug ? $slug->value : $slug;

        return $this->permissions->contains('slug', $value);
    }
}
