<?php

namespace App\Models;

use App\Enums\PermissionSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    protected $fillable = [
        'slug',
        'label',
        'description',
    ];

    protected $casts = [
        'slug' => PermissionSlug::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'permission_id', 'user_id');
    }
}
