<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'specialization',
        'date_of_birth',
        'gender',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function staffType()
    {
        return $this->belongsTo(StaffType::class);
    }

    public function phoneNumbers()
    {
        return $this->morphMany(Phone::class, 'owner');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'owner');
    }

    public function workingHours()
    {
        return $this->morphMany(WorkingHour::class, 'owner');
    }

}
