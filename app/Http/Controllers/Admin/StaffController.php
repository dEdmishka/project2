<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        Auth::shouldUse('admin');

        $user = Auth::user();

        $centerId = $request->query('center');

        $staff = Staff::with([
            'center',
            'user',
            'staffType',
            'phoneNumbers',
            'socialLinks',
            'workingHours',
        ])->where('center_id', $centerId ?? null)->get();

        $centers = Center::all();
        $users = User::where('role', 'regular')->whereDoesntHave('staff')->whereDoesntHave('patient')->get();
        $staffTypes = StaffType::all();

        $staff = $staff->map(function ($item) {
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
                'staffType' => $item->staffType,
                'phones' => $item->phoneNumbers,
                'social_links' => $item->socialLinks,
                'working_hours' => $item->workingHours,
            ];
        });

        return Inertia::render('Admin/Staff/Index', [
            'data' => Inertia::lazy(fn() => $staff),
            'user' => $user,
            'centers' => $centers,
            'users' => $users,
            'staffTypes' => $staffTypes,
            'main_url' => route('admin.staff.index'),
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
            'staff_type' => 'required|exists:staff_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $patient = Staff::create([
                'user_id' => $request->user,
                'center_id' => $request->center,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
                'staff_type_id' =>  $request->staff_type,
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

            foreach ($request->working_hours as $hours) {
                $patient->workingHours()->create([
                    'day_of_week' => (string) $hours['day_of_week'],
                    'start_time' => $hours['is_day_off'] ? null : $hours['start_time'],
                    'end_time' => $hours['is_day_off'] ? null : $hours['end_time'],
                    'is_day_off' => $hours['is_day_off'],
                ]);
            }   
        });

        return redirect()->back()->with('success', __('admin.staff_created'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'center' => 'required|exists:centers,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $staff->user->id,
            'birth_date' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'staff_type' => 'required|exists:staff_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($staff, $request) {
            $staff->user()->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            $staff->update([
                'center_id' => $request->center,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
                'staff_type_id' => $request->staff_type,
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

        return redirect()->back()->with('success', __('admin.staff_edited'));
    }

    public function delete($id)
    {
        $staff = Staff::findOrFail($id);

        if ($staff) {
            DB::transaction(function () use ($staff) {
                $staff->delete();

                $staff->phoneNumbers()->delete();

                $staff->socialLinks()->delete();

                $staff->workingHours()->delete();
            });

            return redirect()->back()->with('success', __('admin.staff_deleted'));
        }

        return redirect()->back()->withErrors(['msg' => __('admin.no_staff_delete')]);
    }
}
