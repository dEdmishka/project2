<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'record_type_id',
        'content',
    ];

    public function recordType()
    {
        return $this->belongsTo(RecordType::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
