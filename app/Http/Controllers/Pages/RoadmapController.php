<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoadmapController extends Controller
{
    public function patient()
    {
        return Inertia::render('Roadmap/Patient', [
            'auth_user' => Auth::user(),
        ]);
    }

    public function employee()
    {
        return Inertia::render('Roadmap/Employee', [
            'auth_user' => Auth::user(),
        ]);
    }

    public function admin()
    {
        return Inertia::render('Roadmap/Admin', [
            'auth_user' => Auth::user(),
        ]);
    }

    public function center()
    {
        return Inertia::render('Roadmap/Center', [
            'auth_user' => Auth::user(),
        ]);
    }
}
