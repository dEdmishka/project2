<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use App\Models\Ward;
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
            $staffId = $user->staff->id;
            $centerId = $user->staff->center_id;

            $appointments = Appointment::with([
                'ward.procedure',
                'patient.user',
                'staff.user',
            ])
                ->whereHas('staff', function ($query) use ($staffId) {
                    $query->where('staff.id', $staffId);
                })
                ->whereHas('patient', function ($query) use ($centerId) {
                    $query->where('center_id', $centerId);
                })
                ->get();

            $appointments = $appointments->map(function ($item) {
                return [
                    'id' => $item->id,
                    'time' => $item->time,
                    'status' => $item->status,
                    'notes' => $item->notes,
                    'patient' => $item->patient,
                    'staff' => $item->staff,
                    'ward' => $item->ward,
                ];
            });

            return Inertia::render('Account/Staff/Appointment/Index', [
                'user' => $user,
                'data' => $appointments,
                'main_url' => route('account.appointment'),
            ]);
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

        // dd($request, $appointmentTime, $appointmentTimeEnd);

        // $ward = Ward::findOrFail($request->ward);
        // $appointmentTime = Carbon::parse($request->time);
        // $procedure = $ward->procedure;

        // $appointmentTimeEnd = $appointmentTime->copy()->addMinutes($procedure->duration);

        // // 1. Перевірка на перевищення capacity
        // $activeAppointments = Appointment::where('ward_id', $ward->id)
        //     ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
        //     ->count();

        // if ($activeAppointments >= $ward->capacity) {
        //     return redirect()->back()->withErrors(['ward' => __('admin.ward_full')])->withInput();
        // }

        // // 2. Перевірка на конфлікт за пацієнтом
        // $conflictForPatient = Appointment::where('patient_id', $request->patient)
        //     ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
        //     ->exists();

        // if ($conflictForPatient) {
        //     return redirect()->back()->withErrors(['patient' => __('admin.patient_has_appointment')])->withInput();
        // }

        // // 3. Перевірка на конфлікт за спеціалістом
        // foreach ($request->staff as $staffId) {
        //     $staff = Staff::with(['appointments' => function ($query) {
        //         $query->where('status', '!=', 'cancelled'); // skip cancelled ones, if needed
        //     }])->find($staffId);

        //     if (!$staff) continue;

        //     foreach ($staff->appointments as $appt) {
        //         $existingStart = Carbon::parse($appt->time);
        //         $existingEnd = $existingStart->copy()->addMinutes($procedure->duration);

        //         if (
        //             $appointmentTime->lt($existingEnd) &&
        //             $appointmentTimeEnd->gt($existingStart)
        //         ) {
        //             return redirect()->back()->withErrors([
        //                 'staff' => __('admin.staff_booked', ['first_name' => $staff->user->first_name, 'last_name' => $staff->user->last_name, 'start' => $existingStart->format('H:i'), 'end' => $existingEnd->format('H:i')])
        //             ])->withInput();
        //         }
        //     }
        // }

        // // 4. Перевірка на розклад за спеціалістом
        // $dayOfWeek = ($appointmentTime->dayOfWeek + 6) % 7; // 0 (Mon) - 6 (Sun)

        // foreach ($request->staff as $staffId) {
        //     $staff = Staff::with(['workingHours', 'user'])->findOrFail($staffId);

        //     $workingHour = $staff->workingHours
        //         ->where('day_of_week', $dayOfWeek)
        //         ->where('is_day_off', false)
        //         ->first();

        //     if (!$workingHour) {
        //         return redirect()->back()->withErrors(['staff' => __('admin.staff_not_available', ['first_name' => $staff->user->first_name, 'last_name' => $staff->user->last_name])])->withInput();
        //     }

        //     $start = Carbon::parse($workingHour->start_time);
        //     $end = Carbon::parse($workingHour->end_time);

        //     $appointmentTime = Carbon::createFromFormat('H:i:s', $appointmentTime->format('H:i:s'));
        //     $appointmentTimeEnd = Carbon::createFromFormat('H:i:s', $appointmentTimeEnd->format('H:i:s'));

        //     if (
        //         $appointmentTime->lt($start) ||
        //         $appointmentTimeEnd->gt($end)
        //     ) {
        //         return redirect()->back()->withErrors(['staff' => __('admin.appointment_outside', ['first_name' => $staff->user->first_name, 'last_name' => $staff->user->last_name])])->withInput();
        //     }
        // }

        // $appointment = Appointment::create([
        //     'time' => $request->time,
        //     'status' => $request->status,
        //     'notes' => $request->notes,
        //     'patient_id' => $request->patient,
        //     'ward_id' => $request->ward,
        // ]);

        // $appointment->staff()->attach($request->staff);

        return redirect()->route('account.appointment')->with('success', __('account.appointment_created'));
    }
}
