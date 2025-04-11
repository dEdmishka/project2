<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::get();
        // dd($procedures);
        return Inertia::render('Admin/Procedure/Index', [
            'data' => $procedures,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => '',
            'duration' => 'required',
            'price' => 'required',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $procedure = Procedure::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Successfully created');
    }
}
