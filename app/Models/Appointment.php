<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'time',
        'status',
        'notes',
        'patient_id',
        'staff_id',
        'procedure_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
