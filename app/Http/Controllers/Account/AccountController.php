<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
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
            return Inertia::render('Account/User/Index', [
                'user' => $user,
                'mainUrl' => route('account.index'),
            ]);
        }

        if ($user->is_staff) {
            return Inertia::render('Account/Staff/Index', [
                'user' => $user,
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
        }

        if ($user->is_staff) {
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $request->id,
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
