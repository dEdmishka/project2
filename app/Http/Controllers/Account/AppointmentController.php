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

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patientId = $user->patient->id;
            $centerId = $user->patient->center_id;

            $appointments = Appointment::with(['staff.user', 'ward.procedure', 'patient' => function ($query) use ($centerId) {
                $query->where('center_id', $centerId);
            }])->where('patient_id', $patientId)->get();

            // dd($appointments);

            $appointments = $appointments->map(function ($item) {
                return [
                    'id' => $item->id,
                    'time' => $item->time,
                    'status' => $item->status,
                    'notes' => $item->notes,
                    'staff' => $item->staff,
                    'ward' => $item->ward,
                ];
            });

            return Inertia::render('Account/Patient/Appointment/Index', [
                'user' => $user,
                'data' => $appointments,
                'main_url' => route('account.appointment'),
            ]);
        }

        if ($user->is_staff) {
        }

        return redirect()->back();
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
