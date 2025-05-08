<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'report_type_id',
        'content',
    ];

    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
