<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centerId = $request->query('center');

        $patients = Patient::with([
            'center',
            'user',
            'phoneNumbers',
            'socialLinks',
        ])->where('center_id', $centerId ?? null)->get();

        $users = User::where('role', 'regular')->whereDoesntHave('staff')->whereDoesntHave('patient')->get();

        $centers = Center::all();

        $patients = $patients->map(function ($item) {
            return [
                'id' => $item->id,
                'first_name' => $item->user->first_name,
                'last_name' => $item->user->last_name,
                'email' => $item->user->email,
                'birth_date' => $item->birth_date,
                'address' => $item->address,
                'gender' => $item->gender,
                'status' => $item->status,
                'center' => $item->center,
                'phones' => $item->phoneNumbers,
                'social_links' => $item->socialLinks,
            ];
        });

        return Inertia::render('Admin/Patient/Index', [
            'data' => Inertia::lazy(fn() => $patients),
            'user' => $user,
            'centers' => $centers,
            'users' => $users,
            'main_url' => route('admin.patient.index'),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'center' => 'required|exists:centers,id',
            'birth_date' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $patient = Patient::create([
                'user_id' => $request->user,
                'center_id' => $request->center,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
            ]);

            foreach ($request->phones as $phone) {
                $patient->phoneNumbers()->create([
                    'phone_number' => $phone['phone_number'],
                ]);
            }

            foreach ($request->social_links as $link) {
                $patient->socialLinks()->create([
                    'url' => $link['url'],
                    'platform' => detectPlatformFromUrl($link['url']),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Patient has been successfully created!');
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'center' => 'required|exists:centers,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $patient->user->id,
            'birth_date' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($patient, $request) {
            $patient->user()->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            $patient->update([
                'center_id' => $request->center,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
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

        return redirect()->back()->with('success', 'Patient has been successfully edited!');
    }

    public function delete($id)
    {
        $patient = Patient::findOrFail($id);

        if ($patient) {
            DB::transaction(function () use ($patient) {
                $patient->delete();

                $patient->phoneNumbers()->delete();

                $patient->socialLinks()->delete();
            });

            return redirect()->back()->with('success', 'Patient has been successfully deleted!');
        }

        return redirect()->back()->withErrors(['msg' => 'There`s no patient to delete!']);
    }
}
