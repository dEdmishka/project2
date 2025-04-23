<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HelpController extends Controller
{
    public function index()
    {
        return Inertia::render('Help/Index', [
            'auth_user' => Auth::user(),
        ]);
    }
}
