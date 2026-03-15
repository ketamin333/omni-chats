<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'company_name',
        'address',
        'api_key',
    ];

    protected $hidden = ['api_key'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id', 'company_id');
    }
}
