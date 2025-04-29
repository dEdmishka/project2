<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'content',
    ];
    
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
