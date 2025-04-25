<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
