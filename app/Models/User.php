<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    const DEFAULT_AVATAR = 'default_avatar.png';

    protected $fillable = [
        'company_id',
        'username',
        'email',
        'password',
        'avatar',
        'phone',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $attributes = [
        'avatar' => self::DEFAULT_AVATAR,
    ];

    protected $casts = [
        'password' => 'hashed'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
