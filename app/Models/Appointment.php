<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'time',
        'status',
        'notes',
        'patient_id',
        'ward_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
