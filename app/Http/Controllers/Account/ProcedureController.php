<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Staff;
use App\Models\User;
use App\Models\Ward;
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

        $procedures = Procedure::with([
            'wards'
        ])->whereHas('wards', function ($query) use ($centerId) {
            $query->whereHas('department', function ($q) use ($centerId) {
                $q->where('center_id', $centerId);
            });
        })->where('is_active', true)->get();

        $procedures = $procedures->filter(function ($item) {
            return $item->wards->isNotEmpty();
        })->values();

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
        $user = Auth::user()->load('image');

        if (!$user->is_patient) {
            return redirect()->back();
        }

        $patientId = $user->patient->id;
        $centerId = $user->patient->center_id;

        $validator = Validator::make($request->all(), [
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointmentTime = Carbon::parse($request->time);
        $appointmentTimeEnd = $appointmentTime->copy()->addMinutes($request->duration);
        $dayOfWeek = ($appointmentTime->dayOfWeek + 6) % 7;

        // dd($request, $appointmentTime, $appointmentTimeEnd);

        // 🧠 1. Find a ward with the selected procedure and center
        $ward = Ward::whereHas('department', function ($query) use ($centerId) {
            $query->where('center_id', $centerId);
        })
            ->where('procedure_id', $request->procedure_id)
            ->first();

        if (!$ward) {
            return redirect()->back()->withErrors(['time' => __('account.no_available_ward')])->withInput();
        }

        // 1. Перевірка на перевищення capacity
        $activeAppointments = Appointment::where('ward_id', $ward->id)
            ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
            ->count();

        if ($activeAppointments >= $ward->capacity) {
            return redirect()->back()->withErrors(['ward' => __('admin.ward_full')])->withInput();
        }

        // 2. Перевірка на конфлікт за пацієнтом
        $conflictForPatient = Appointment::where('patient_id', $patientId)
            ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
            ->exists();

        if ($conflictForPatient) {
            return redirect()->back()->withErrors(['time' => __('admin.patient_has_appointment')])->withInput();
        }

        // 🧠 2. Find staff
        $availableStaff = Staff::where('center_id', $centerId)
            ->whereHas('workingHours', function ($query) use ($appointmentTime, $appointmentTimeEnd, $dayOfWeek) {
                $query
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_day_off', false)
                    ->whereTime('start_time', '<=', $appointmentTime->format('H:i:s'))
                    ->whereTime('end_time', '>=', $appointmentTimeEnd->format('H:i:s'));
            })
            ->get()
            ->filter(function ($staff) use ($appointmentTime) {
                return !$staff->appointments()->where('status', '!=', 'cancelled')->where('time', $appointmentTime->toDateTimeString())->exists();
            })
            ->first();

        if (!$availableStaff) {
            return redirect()->back()->withErrors(['time' => __('account.no_available_staff')])->withInput();
        }

        // 🧠 3. Create appointment
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'ward_id' => $ward->id,
            'time' => $request->time,
            'status' => 'active',
            'notes' => null,
        ]);

        // dd($appointment, $availableStaff->id);

        $appointment->staff()->attach($availableStaff->id);

        return redirect()->route('account.appointment')->with('success', __('account.appointment_created'));
    }
}
