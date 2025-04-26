<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProcedureController extends Controller
{
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $procedures = Procedure::get();
        // dd($procedures);
        return Inertia::render('Admin/Procedure/Index', [
            'data' => $procedures,
            'user' => $user,
            'main_url' => route('admin.procedure.index'),
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

        return redirect()->back()->with('success', 'Product has been successfully created!');
    }

    public function update(Request $request, $id) {
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

        Procedure::whereId($id)->update($request->all());

        return redirect()->back()->with('success', 'Product has been successfully edited!');
    }    

    public function delete($id) {
        $procedure = Procedure::find($id);

        if ($procedure) {
            $procedure->delete();
            return redirect()->back()->with('success', 'Product has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no procedure to delete!']);
    }    
}
