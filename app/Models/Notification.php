<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_type_id',
        'recipient_id',
        'sender_id',
        'content',
        'status'
    ];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
