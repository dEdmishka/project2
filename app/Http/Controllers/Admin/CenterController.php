<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CenterController extends Controller
{
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centers = Center::get();
        // dd($centers);
        return Inertia::render('Admin/Center/Index', [
            'data' => $centers,
            'user' => $user,
            'main_url' => route('admin.center.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'description' => 'required',
            'address' => 'required',
            'phones' => 'required|array|min:1',
            'phones.*.number' => 'required|string|max:20',
            'social_links' => 'required|array|min:1',
            'social_links.*.url' => 'required|string',
            'working_hours' => 'required|array|size:7',
            'working_hours.*.day_of_week' => 'required|integer|min:0|max:6',
            'working_hours.*.start_time' => 'required_if:working_hours.*.is_day_off,false|date_format:H:i',
            'working_hours.*.end_time' => 'required_if:working_hours.*.is_day_off,false|date_format:H:i',
            'working_hours.*.is_day_off' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $center = Center::create([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        foreach ($request->phones as $phone) {
            $center->phoneNumbers()->create([
                'phone_number' => $phone['number'],
            ]);
        }

        foreach ($request->social_links as $link) {
            $center->socialLinks()->create([
                'url' => $link['url'],
                'platform' => detectPlatformFromUrl($link['url']),
            ]);
        }

        foreach ($request->working_hours as $hours) {
            $center->workingHours()->create([
                'day_of_week' => (string) $hours['day_of_week'],
                'start_time' => $hours['is_day_off'] ? null : $hours['start_time'],
                'end_time' => $hours['is_day_off'] ? null : $hours['end_time'],
                'is_day_off' => $hours['is_day_off'],
            ]);
        }

        return redirect()->back()->with('success', 'Center has been successfully created!');
    }

    public function update(Request $request, $id)
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

        // Procedure::whereId($id)->update($request->all());

        return redirect()->back()->with('success', 'Center has been successfully edited!');
    }

    public function delete($id)
    {
        // $procedure = Procedure::find($id);

        // if ($procedure) {
        //     $procedure->delete();
        //     return redirect()->back()->with('success', 'Center has been successfully deleted!');
        // }

        return redirect()->back()->withErrors(['msg' => 'There`s no procedure to delete!']);
    }
}
