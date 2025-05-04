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
    ];

    public function workingHours()
    {
        return $this->morphMany(WorkingHour::class, 'working_hourable');
    }

    public function phoneNumbers()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'social_linkable');
    }

    public function department()
    {
        return $this->hasMany(Department::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
