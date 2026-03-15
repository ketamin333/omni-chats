<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    protected $attributes = [
        'avatar' => 'default_avatar.png',
    ];

    protected $casts = [
        'password' => 'hashed'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
