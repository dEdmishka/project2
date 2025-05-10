<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        $notifications = $user()
            ->notifications()
            ->with('notificationType')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->notificationType->type,
                    'content' => $notification->content,
                    'sender_id' => $notification->sender_id,
                    'status' => $notification->status,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return Inertia::render('Account/Notification/Index', [
            'user' => $user,
            'data' => $notifications,
            'main_url' => route('account.notification'),
        ]);
    }
}
