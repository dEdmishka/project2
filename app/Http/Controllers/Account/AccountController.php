<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patient = Patient::with(['phoneNumbers', 'socialLinks'])->find($user->patient->id);

            return Inertia::render('Account/Patient/Index', [
                'user' => array_merge(
                    $user->toArray(),
                    ['patient' => $patient]
                ),
                'mainUrl' => route('account.index'),
            ]);
        }

        if ($user->is_staff) {
            $staff = Staff::with(['phoneNumbers', 'socialLinks', 'workingHours'])->find($user->staff->id);

            return Inertia::render('Account/Staff/Index', [
                'user' => array_merge(
                    $user->toArray(),
                    ['staff' => $staff]
                ),
                'mainUrl' => route('account.index'),
            ]);
        }

        return Inertia::render('Account/User/Index', [
            'user' => $user,
            'mainUrl' => route('account.index'),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patient = Patient::findOrFail($user->patient->id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email,' . $user->id,
                'image' => '',
                'birth_date' => 'required',
                'address' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function () use ($user, $patient, $request) {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);

                if ($request->hasFile('image')) {
                    $image_path = $request->file('image')->store('images', 'public');

                    $user->image()->update([
                        'url' => 'storage/' . $image_path,
                    ]);
                }

                $patient->update([
                    'birth_date' => $request->birth_date,
                    'address' => $request->address,
                    'gender' => $request->gender,
                ]);

                $patient->phoneNumbers()->delete();
                if (!empty($request->phones)) {
                    foreach ($request->phones as $phone) {
                        $patient->phoneNumbers()->create([
                            'phone_number' => $phone['phone_number'],
                        ]);
                    }
                }

                $patient->socialLinks()->delete();
                if (!empty($request->social_links)) {
                    foreach ($request->social_links as $link) {
                        $patient->socialLinks()->create([
                            'url' => $link['url'],
                            'platform' => detectPlatformFromUrl($link['url']),
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', __('account.patient_updated'));
        }

        if ($user->is_staff) {
            $staff = Staff::findOrFail($user->staff->id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email,' . $user->id,
                'image' => '',
                'birth_date' => 'required',
                'address' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function () use ($user, $staff, $request) {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);

                if ($request->hasFile('image')) {
                    $image_path = $request->file('image')->store('images', 'public');

                    $user->image()->update([
                        'url' => 'storage/' . $image_path,
                    ]);
                }

                $staff->update([
                    'birth_date' => $request->birth_date,
                    'address' => $request->address,
                    'gender' => $request->gender,
                ]);

                $staff->phoneNumbers()->delete();
                if (!empty($request->phones)) {
                    foreach ($request->phones as $phone) {
                        $staff->phoneNumbers()->create([
                            'phone_number' => $phone['phone_number'],
                        ]);
                    }
                }

                $staff->socialLinks()->delete();
                if (!empty($request->social_links)) {
                    foreach ($request->social_links as $link) {
                        $staff->socialLinks()->create([
                            'url' => $link['url'],
                            'platform' => detectPlatformFromUrl($link['url']),
                        ]);
                    }
                }

                
                $staff->workingHours()->delete();
                if (!empty($request->working_hours)) {
                    foreach ($request->working_hours as $hour) {
                        $staff->workingHours()->create([
                            'day_of_week' => $hour['day_of_week'],
                            'start_time' => $hour['start_time'] ?? null,
                            'end_time' => $hour['end_time'] ?? null,
                            'is_day_off' => $hour['is_day_off'],
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', __('account.staff_updated'));
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'image' => ''
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($user, $request) {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('images', 'public');

                $user->image()->update([
                    'url' => 'storage/' . $image_path,
                ]);
            }
        });

        return redirect()->back()->with('success', __('account.user_updated'));
    }
}
