<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Department;
use App\Models\Document;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Staff;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        return Inertia::render('Admin/Dashboard/Index', [
            'user' => $user,
        ]);
    }

    public function home()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centers = Center::all()->count();
        $users = User::all()->count();
        $patients = Patient::all()->count();
        $staff = Staff::all()->count();
        $wards = Ward::all()->count();
        $appointments = Appointment::all()->count();
        $departments = Department::all()->count();
        $procedures = Procedure::all()->count();
        $documents = Document::all()->count();
        $notifications = Notification::all()->count();

        return Inertia::render('Admin/Home/Index', [
            'user' => $user,
            'centers' => $centers,
            'users' => $users,
            'patients' => $patients,
            'staff' => $staff,
            'wards' => $wards,
            'appointments' => $appointments,
            'departments' => $departments,
            'procedures' => $procedures,
            'documents' => $documents,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
