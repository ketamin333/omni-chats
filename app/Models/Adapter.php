<?php

namespace App\Models;

use App\Enums\AdapterName;
use App\Enums\AdapterType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adapter extends Model
{
    protected $table = 'adapters';
    protected $primaryKey = 'adapter_id';

    protected $fillable = [
        'adapter_name',
        'adapter_type',
        'slug',
        'handler',
        'settings_schema',
        'is_enabled',
    ];

    protected $casts = [
        'adapter_name'    => AdapterName::class,
        'adapter_type'    => AdapterType::class,
        'settings_schema' => 'array',
        'is_enabled'      => 'boolean',
    ];

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'company_id', 'company_id');
    }
}
