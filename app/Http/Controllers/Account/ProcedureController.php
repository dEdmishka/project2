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

class ProcedureController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if (!$user->is_patient) {
            return redirect()->back();
        }

        $centerId = $user->patient->center_id;

        $procedures = Procedure::with(['wards.department' => function ($query) use ($centerId) {
            $query->where('center_id', $centerId);
        }])->where('is_active', true)->get();

        $procedures = $procedures->filter(function ($item) {
            return $item->wards->isNotEmpty();
        })->values();

        // $appointments = Appointment::with(['ward.procedure' => function ($query) use ($centerId) {
        //     $query->where('center_id', $centerId);
        // }])->get();

        // dd($appointments);

        $procedures = $procedures->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'cost' => $item->cost,
                'duration' => $item->duration,
                'wards' => $item->wards,
            ];
        });

        return Inertia::render('Account/Patient/Procedure/Index', [
            'user' => $user,
            'data' => $procedures,
            // 'appointments' => $appointments,
            'main_url' => route('account.procedure'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointmentTime = Carbon::parse($request->time);
        $appointmentTimeEnd = $appointmentTime->copy()->addMinutes($request->duration);

        // DB::transaction(function () use ($request) {
        //     $patient = Patient::create([
        //         'user_id' => $request->user_id,
        //         'center_id' => $request->center_id,
        //         'birth_date' => $request->birth_date,
        //         'address' => $request->address,
        //         'gender' => $request->gender,
        //         'status' => 'active',
        //     ]);

        //     foreach ($request->phones as $phone) {
        //         $patient->phoneNumbers()->create([
        //             'phone_number' => $phone['phone_number'],
        //         ]);
        //     }

        //     foreach ($request->social_links as $link) {
        //         $patient->socialLinks()->create([
        //             'url' => $link['url'],
        //             'platform' => detectPlatformFromUrl($link['url']),
        //         ]);
        //     }
        // });

        return redirect()->route('account.appointment')->with('success', 'Appointment has been successfully created!');
    }
}
