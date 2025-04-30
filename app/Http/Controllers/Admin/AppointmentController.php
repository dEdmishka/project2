<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $appointments = Appointment::with([
            'patient',
            'staff',
            'procedure',
        ])->get();

        $patients = Patient::all();
        $staff = Staff::all();
        $procedures = Procedure::all();
 
        $appointments = $appointments->map(function ($item) {
            return [
                'id' => $item->id,
                'time' => $item->time,
                'status' => $item->status,
                'notes' => $item->notes,
                'patient' => $item->patient,
                'staff' => $item->staff,
                'procedure' => $item->procedure,
            ];
        });

        return Inertia::render('Admin/Appointment/Index', [
            'data' => $appointments,
            'user' => $user,
            'patients' => $patients,
            'staff' => $staff,
            'procedures' => $procedures,
            'main_url' => route('admin.appointment.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'status' => 'required',
            'notes' => 'required',
            'patient' => 'required|exists:patients,id',
            'staff' => 'required|exists:staff,id',
            'procedure' => 'required|exists:procedures,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointment = Appointment::create([
            'time' => $request->time,
            'status' => $request->status,
            'notes' => $request->notes,
            'patient_id' => $request->patient,
            'staff_id' => $request->staff,
            'procedure_id' => $request->procedure,
        ]);

        return redirect()->back()->with('success', 'Appointment has been successfully created!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'status' => 'required',
            'notes' => 'required',
            'patient' => 'required|exists:patients,id',
            'staff' => 'required|exists:staff,id',
            'procedure' => 'required|exists:procedures,id',
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
            'staff_id' => $request->staff,
            'procedure_id' => $request->procedure,
        ]);

        return redirect()->back()->with('success', 'Appointment has been successfully edited!');
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment) {
            $appointment->delete();

            return redirect()->back()->with('success', 'Appointment has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no appointment to delete!']);
    }
}
