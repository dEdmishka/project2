<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->is_patient) {
            return Inertia::render('Account/User/Index', [
                'user' => $user,
            ]);
        }

        if ($user->is_staff) {
            return Inertia::render('Account/Staff/Index', [
                'user' => $user,
            ]);
        }
        
        return Inertia::render('Account/User/Index', [
            'user' => $user,
        ]);
    }
}
