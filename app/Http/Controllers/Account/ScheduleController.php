<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_staff) {
            $staffId = $user->staff->id;
            $centerId = $user->staff->center_id;

            $patients = Patient::with([
                'appointments',
                'user',
            ])->where('center_id', $centerId)
                ->whereHas('appointments', function ($query) use ($staffId) {
                    $query->whereHas('staff', function ($q) use ($staffId) {
                        $q->where('staff.id', $staffId);
                    });
                })
                ->get();

            // dd($patients);

            $patients = $patients->map(function ($item) {
                return [
                    'id' => $item->id,
                    'first_name' => $item->user->first_name,
                    'last_name' => $item->user->last_name,
                    'email' => $item->user->email,
                    'birth_date' => $item->birth_date,
                    'address' => $item->address,
                    'gender' => $item->gender,
                    'status' => $item->status,
                    'phones' => $item->phone_numbers,
                    'social_links' => $item->social_links,
                ];
            });

            return Inertia::render('Account/Staff/Schedule/Index', [
                'user' => $user,
                'data' => $patients,
                'main_url' => route('account.schedule'),
            ]);
        }

        return redirect()->back();
    }
}
