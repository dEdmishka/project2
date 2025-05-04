<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CenterController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        $centers = Center::with([
            'phoneNumbers',
            'socialLinks',
            'workingHours',
            'images',
        ])->get();

        $centers = $centers->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'description' => $item->description,
                'address' => $item->address,
                'images' => $item->images,
                'phones' => $item->phoneNumbers,
                'social_links' => $item->socialLinks,
                'working_hours' => $item->workingHours,
            ];
        });

        if ($user->is_patient) {
            return Inertia::render('Account/User/Center/Index', [
                'user' => $user,
                'data' => $centers,
                'main_url' => route('account.center'),
            ]);
        }

        if ($user->is_staff) {
            return Inertia::render('Account/Staff/Center/Index', [
                'user' => $user,
                'data' => $centers,
                'main_url' => route('account.center'),
            ]);
        }

        return Inertia::render('Account/User/Center/Index', [
            'user' => $user,
            'data' => $centers,
            'main_url' => route('account.center'),
        ]);
    }

    public function show(Request $request, $id)
    {
        // dd($id);
        $user = Auth::user()->load('image');

        $center = Center::with([
            'phoneNumbers',
            'socialLinks',
            'workingHours',
            'images',
        ])->findOrFail($id);

        return Inertia::render('Account/User/Center/Show', [
            'user' => $user,
            'center' => $center,
            'main_url' => route('account.center'),
        ]);
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|unique:centers,email|email',
        //     'description' => 'required',
        //     'address' => 'required',
        //     'phones' => 'required|array|min:1',
        //     'phones.*.phone_number' => 'required|string|max:20',
        //     'social_links' => 'required|array|min:1',
        //     'social_links.*.url' => 'required|string',
        //     'working_hours' => 'required|array|size:7',
        //     'working_hours.*.day_of_week' => 'required|integer|min:0|max:6',
        //     'working_hours.*.start_time' => 'required_if:working_hours.*.is_day_off,false',
        //     'working_hours.*.end_time' => 'required_if:working_hours.*.is_day_off,false',
        //     'working_hours.*.is_day_off' => 'required|boolean',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // DB::transaction(function () use ($request) {
        //     $center = Center::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'description' => $request->description,
        //         'address' => $request->address,
        //     ]);

        //     foreach ($request->phones as $phone) {
        //         $center->phoneNumbers()->create([
        //             'phone_number' => $phone['phone_number'],
        //         ]);
        //     }

        //     foreach ($request->social_links as $link) {
        //         $center->socialLinks()->create([
        //             'url' => $link['url'],
        //             'platform' => detectPlatformFromUrl($link['url']),
        //         ]);
        //     }

        //     foreach ($request->working_hours as $hours) {
        //         $center->workingHours()->create([
        //             'day_of_week' => (string) $hours['day_of_week'],
        //             'start_time' => $hours['is_day_off'] ? null : $hours['start_time'],
        //             'end_time' => $hours['is_day_off'] ? null : $hours['end_time'],
        //             'is_day_off' => $hours['is_day_off'],
        //         ]);
        //     }
        // });

        return redirect()->back()->with('success', 'Center has been successfully created!');
    }
}
