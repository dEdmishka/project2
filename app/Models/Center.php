<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Center extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'description',
        'start_time',
        'close_time',
    ];

    public function phoneNumbers()
    {
        return $this->morphMany(Phone::class, 'owner');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'owner');
    }
}
