<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CenterController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient || $user->is_staff) {
            return redirect()->back();
        }

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

        if ($user->is_patient) {
            return redirect()->back();
        }

        if ($user->is_staff) {
            return redirect()->back();
        }

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
        $validator = Validator::make($request->all(), [
            'birth_date' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'phones' => 'required|array|min:1',
            'phones.*.phone_number' => 'required|string|max:20',
            'social_links' => 'required|array|min:1',
            'social_links.*.url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // DB::transaction(function () use ($request) {
        //     $patient = Patient::create([
        //         'user_id' => $request->user_id,
        //         'center_id' => $request->center_id,
        //         'birth_date' => $request->birth_date,
        //         'address' => $request->address,
        //         'gender' => $request->gender,
        //         'status' => 'active',
        //     ]);

        //     foreach ($request->phones as $phone) {
        //         $patient->phoneNumbers()->create([
        //             'phone_number' => $phone['phone_number'],
        //         ]);
        //     }

        //     foreach ($request->social_links as $link) {
        //         $patient->socialLinks()->create([
        //             'url' => $link['url'],
        //             'platform' => detectPlatformFromUrl($link['url']),
        //         ]);
        //     }
        // });

        return redirect()->route('account.index')->with('success', __('account.patient_created'));
    }
}
