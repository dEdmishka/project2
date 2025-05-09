<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'recordable_id',
        'recordable_type',
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
