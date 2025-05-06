<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $table = 'procedures';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'is_active',
    ];

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
