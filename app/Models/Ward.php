<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'ward_number',
        'capacity',
        'procedure_id',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function appointment()
    {
        return $this->belongsToMany(Appointment::class);
    }
}
