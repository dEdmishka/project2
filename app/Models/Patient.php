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
        'date_of_birth',
        'gender',
        'address',
        'status',
        'center_id',
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
}
