<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\NotificationType;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
        }
        if ($user->is_staff) {
        }

        $notificationTypes = NotificationType::all();

        $notifications = $user->notifications()
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
                    'created_at' => $notification->created_at,
                ];
            });

        return Inertia::render('Account/Notification/Index', [
            'user' => $user,
            'data' => $notifications,
            'types' => $notificationTypes,
            'main_url' => route('account.notification'),
        ]);
    }
}
