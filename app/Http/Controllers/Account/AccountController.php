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
            $staff = Staff::with(['phoneNumbers', 'socialLinks', 'workingHours'])->find(Auth::id());

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

            return redirect()->back()->with('success', 'Patient has been successfully updated!');
        }

        if ($user->is_staff) {
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

        return redirect()->back()->with('success', 'User has been successfully updated!');
    }
}
