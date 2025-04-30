<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Procedure;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class WardController extends Controller
{
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $wards = Ward::with([
            'department',
            'procedure',
        ])->get();

        $departments = Department::all();
        $procedures = Procedure::all();

        $wards = $wards->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'ward_number' => $item->ward_number,
                'capacity' => $item->capacity,
                'department' => $item->department,
                'procedure' => $item->procedure,
            ];
        });

        return Inertia::render('Admin/Ward/Index', [
            'data' => $wards,
            'user' => $user,
            'departments' => $departments,
            'procedures' => $procedures,
            'main_url' => route('admin.ward.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'ward_number' => 'required|integer',
            'capacity' => 'required|integer',
            'department' => 'required|exists:departments,id',
            'procedure' => 'required|exists:procedures,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ward = Ward::create([
            'name' => $request->name,
            'description' => $request->description,
            'ward_number' => $request->ward_number,
            'capacity' => $request->capacity,
            'department_id' => $request->department,
            'procedure_id' => $request->procedure,
        ]);

        return redirect()->back()->with('success', 'Ward has been successfully created!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'ward_number' => 'required|integer',
            'capacity' => 'required|integer',
            'department' => 'required|exists:departments,id',
            'procedure' => 'required|exists:procedures,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ward = Ward::findOrFail($id);

        $ward->update([
            'name' => $request->name,
            'description' => $request->description,
            'ward_number' => $request->ward_number,
            'capacity' => $request->capacity,
            'department_id' => $request->department,
            'procedure_id' => $request->procedure,
        ]);

        return redirect()->back()->with('success', 'Ward has been successfully edited!');
    }

    public function delete($id)
    {
        $ward = Ward::findOrFail($id);

        if ($ward) {
            $ward->delete();

            return redirect()->back()->with('success', 'Ward has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no ward to delete!']);
    }
}
