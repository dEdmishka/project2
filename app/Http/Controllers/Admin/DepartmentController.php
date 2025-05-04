<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Department;
use App\Models\DepartmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centerId = $request->query('center');

        $departments = Department::with([
            'center',
            'departmentType',
        ])->where('center_id', $centerId ?? null)->get();

        $centers = Center::all();
        $departmentTypes = DepartmentType::all();

        $departments = $departments->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'floor' => $item->floor,
                'center' => $item->center,
                'departmentType' => $item->departmentType,
            ];
        });

        return Inertia::render('Admin/Department/Index', [
            // 'data' => $departments,
            'data' => Inertia::lazy(fn() => $departments),
            'user' => $user,
            'centers' => $centers,
            'departmentTypes' => $departmentTypes,
            'main_url' => route('admin.department.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'floor' => 'required|integer',
            'center' => 'required|exists:centers,id',
            'department_type' => 'required|exists:department_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'floor' => $request->floor,
            'center_id' => $request->center,
            'department_type_id' => $request->department_type,
        ]);

        return redirect()->back()->with('success', 'Department has been successfully created!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'floor' => 'required|integer',
            'center' => 'required|exists:centers,id',
            'department_type' => 'required|exists:department_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'floor' => $request->floor,
            'center_id' => $request->center,
            'department_type_id' => $request->department_type,
        ]);

        return redirect()->back()->with('success', 'Department has been successfully edited!');
    }

    public function delete($id)
    {
        $department = Department::findOrFail($id);

        if ($department) {
            $department->delete();

            return redirect()->back()->with('success', 'Department has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no department to delete!']);
    }
}
