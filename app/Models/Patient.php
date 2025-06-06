<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'birth_date',
        'gender',
        'address',
        'status',
        'center_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function phoneNumbers()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'social_linkable');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function records()
    {
        return $this->morphMany(Record::class, 'recordable');
    }
}
