<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'original_name',
        'disk',
        'path',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }
}
