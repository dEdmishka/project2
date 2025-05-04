<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Staff;
use App\Models\Ward;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centerId = $request->query('center');

        $appointments = Appointment::with([
            'patient.user',
            'staff.user',
            'ward.procedure',
        ])->whereHas('patient', function ($query) use ($centerId) {
            $query->where('center_id', $centerId);
        })->get();

        $centers = Center::all();

        $patients = Patient::with([
            'user',
        ])->get();
        $staff = Staff::with([
            'user',
        ])->get();
        $wards = Ward::with([
            'procedure',
        ])->get();

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

        return Inertia::render('Admin/Appointment/Index', [
            'data' => Inertia::lazy(fn() => $appointments),
            'user' => $user,
            'centers' => $centers,
            'patients' => $patients,
            'staff' => $staff,
            'wards' => $wards,
            'main_url' => route('admin.appointment.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'status' => 'required',
            'notes' => '',
            'patient' => 'required|exists:patients,id',
            'staff' => 'required|array|min:1',
            'ward' => 'required|exists:wards,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ward = Ward::findOrFail($request->ward);
        $appointmentTime = Carbon::parse($request->time);
        $procedure = $ward->procedure;

        $appointmentTimeEnd = $appointmentTime->copy()->addMinutes($procedure->duration);

        // 1. Перевірка на перевищення capacity
        $activeAppointments = Appointment::where('ward_id', $ward->id)
            ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
            ->count();

        if ($activeAppointments >= $ward->capacity) {
            return redirect()->back()->withErrors(['ward' => 'The selected ward is already full at this time.'])->withInput();
        }

        // 2. Перевірка на конфлікт за пацієнтом
        $conflictForPatient = Appointment::where('patient_id', $request->patient)
            ->whereBetween('time', [$appointmentTime, $appointmentTimeEnd->copy()->subMinute()])
            ->exists();

        if ($conflictForPatient) {
            return redirect()->back()->withErrors(['patient' => 'This patient already has an appointment at that time.'])->withInput();
        }

        // 3. Перевірка на конфлікт за спеціалістом
        foreach ($request->staff as $staffId) {
            $staff = Staff::with(['appointments' => function ($query) {
                $query->where('status', '!=', 'cancelled'); // skip cancelled ones, if needed
            }])->find($staffId);

            if (!$staff) continue;

            foreach ($staff->appointments as $appt) {
                $existingStart = Carbon::parse($appt->time);
                $existingEnd = $existingStart->copy()->addMinutes($procedure->duration);

                if (
                    $appointmentTime->lt($existingEnd) &&
                    $appointmentTimeEnd->gt($existingStart)
                ) {
                    return redirect()->back()->withErrors([
                        'staff' => "Staff member {$staff->user->first_name} {$staff->user->last_name} is already booked from {$existingStart->format('H:i')} to {$existingEnd->format('H:i')}."
                    ])->withInput();
                }
            }
        }


        // 4. Перевірка на розклад за спеціалістом
        $dayOfWeek = ($appointmentTime->dayOfWeek + 6) % 7; // 0 (Mon) - 6 (Sun)

        foreach ($request->staff as $staffId) {
            $staff = Staff::with(['workingHours', 'user'])->findOrFail($staffId);

            $workingHour = $staff->workingHours
                ->where('day_of_week', $dayOfWeek)
                ->where('is_day_off', false)
                ->first();

            if (!$workingHour) {
                return redirect()->back()->withErrors(['staff' => "Staff member {$staff->user->first_name} {$staff->user->last_name} is not available on that day."])->withInput();
            }

            $start = Carbon::parse($workingHour->start_time);
            $end = Carbon::parse($workingHour->end_time);

            $appointmentTime = Carbon::createFromFormat('H:i:s', $appointmentTime->format('H:i:s'));
            $appointmentTimeEnd = Carbon::createFromFormat('H:i:s', $appointmentTimeEnd->format('H:i:s'));

            if (
                $appointmentTime->lt($start) ||
                $appointmentTimeEnd->gt($end)
            ) {
                return redirect()->back()->withErrors(['staff' => "Appointment time is outside working hours for staff {$staff->user->first_name} {$staff->user->last_name}."])->withInput();
            }
        }

        $appointment = Appointment::create([
            'time' => $request->time,
            'status' => $request->status,
            'notes' => $request->notes,
            'patient_id' => $request->patient,
            'ward_id' => $request->ward,
        ]);

        $appointment->staff()->attach($request->staff);

        return redirect()->back()->with('success', 'Appointment has been successfully created!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'status' => 'required',
            'notes' => '',
            'patient' => 'required|exists:patients,id',
            'staff' => 'required|array|min:1',
            'ward' => 'required|exists:wards,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'time' => $request->time,
            'status' => $request->status,
            'notes' => $request->notes,
            'patient_id' => $request->patient,
            'ward_id' => $request->ward,
        ]);

        $appointment->staff()->sync($request->staff);

        return redirect()->back()->with('success', 'Appointment has been successfully edited!');
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment) {
            $appointment->staff()->detach();
            $appointment->delete();

            return redirect()->back()->with('success', 'Appointment has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no appointment to delete!']);
    }
}
