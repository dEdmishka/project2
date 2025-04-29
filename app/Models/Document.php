<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'description',
        'is_private',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}
