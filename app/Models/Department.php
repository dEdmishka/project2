<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'floor',
        'center_id',
        'department_type_id',
    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function departmentType()
    {
        return $this->belongsTo(DepartmentType::class);
    }
}
