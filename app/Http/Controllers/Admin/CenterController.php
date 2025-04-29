<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CenterController extends Controller
{
    public function index()
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centers = Center::with([
            'phoneNumbers',
            'socialLinks',
            'workingHours',
        ])->get();

        $centers = $centers->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'description' => $item->description,
                'address' => $item->address,
                'phones' => $item->phoneNumbers,
                'social_links' => $item->socialLinks,
                'working_hours' => $item->workingHours,
            ];
        });

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
            'email' => 'required|unique:centers,email|email',
            'description' => 'required',
            'address' => 'required',
            'phones' => 'required|array|min:1',
            'phones.*.phone_number' => 'required|string|max:20',
            'social_links' => 'required|array|min:1',
            'social_links.*.url' => 'required|string',
            'working_hours' => 'required|array|size:7',
            'working_hours.*.day_of_week' => 'required|integer|min:0|max:6',
            'working_hours.*.start_time' => 'required_if:working_hours.*.is_day_off,false',
            'working_hours.*.end_time' => 'required_if:working_hours.*.is_day_off,false',
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
                'phone_number' => $phone['phone_number'],
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
            'email' => 'required|unique:centers,email,' . $id,
            'description' => 'required',
            'address' => 'required',
            'phones' => 'required|array|min:1',
            'phones.*.phone_number' => 'required|string|max:20',
            'social_links' => 'required|array|min:1',
            'social_links.*.url' => 'required|string',
            'working_hours' => 'required|array|size:7',
            'working_hours.*.day_of_week' => 'required|integer|min:0|max:6',
            'working_hours.*.start_time' => 'required_if:working_hours.*.is_day_off,false',
            'working_hours.*.end_time' => 'required_if:working_hours.*.is_day_off,false',
            'working_hours.*.is_day_off' => 'required|boolean',
        ]);

        // dd($request->working_hours);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $center = Center::findOrFail($id);

        DB::transaction(function () use ($center, $request) {
            $center->update([
                'name' => $request->name,
                'email' => $request->email,
                'description' =>  $request->description,
                'address' => $request->address,
            ]);

            $center->phoneNumbers()->delete();
            if (!empty($request->phones)) {
                foreach ($request->phones as $phone) {
                    $center->phoneNumbers()->create([
                        'phone_number' => $phone['phone_number'],
                    ]);
                }
            }

            $center->socialLinks()->delete();
            if (!empty($request->social_links)) {
                foreach ($request->social_links as $link) {
                    $center->socialLinks()->create([
                        'url' => $link['url'],
                        'platform' => detectPlatformFromUrl($link['url']),
                    ]);
                }
            }

            $center->workingHours()->delete();
            if (!empty($request->working_hours)) {
                foreach ($request->working_hours as $hour) {
                    $center->workingHours()->create([
                        'day_of_week' => $hour['day_of_week'],
                        'start_time' => $hour['start_time'] ?? null,
                        'end_time' => $hour['end_time'] ?? null,
                        'is_day_off' => $hour['is_day_off'],
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Center has been successfully edited!');
    }

    public function delete($id)
    {
        $center = Center::findOrFail($id);

        if ($center) {
            DB::transaction(function () use ($center) {
                $center->delete();

                $center->phoneNumbers()->delete();

                $center->socialLinks()->delete();

                $center->workingHours()->delete();
            });

            return redirect()->back()->with('success', 'Center has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no center to delete!']);
    }
}
