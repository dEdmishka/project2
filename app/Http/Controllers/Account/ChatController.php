<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        $users = User::with([
            'image',
        ])->get();

        if ($user->is_patient) {
            return Inertia::render('Account/User/Chat/Index', [
                'user' => $user,
                'users' => $users,
                'main_url' => route('account.chat'),
            ]);
        }

        if ($user->is_staff) {
            return Inertia::render('Account/Staff/Chat/Index', [
                'user' => $user,
                'users' => $users,
                'main_url' => route('account.chat'),
            ]);
        }
        
        return Inertia::render('Account/User/Chat/Index', [
            'user' => $user,
            'users' => $users,
            'main_url' => route('account.chat'),
        ]);
    }
}
