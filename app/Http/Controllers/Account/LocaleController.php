<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class LocaleController extends Controller
{
    public function locale(Request $request)
    {
        $locale = $request->locale;

        if (!in_array($locale, ['en', 'ua'])) {
            abort(400, 'Invalid locale');
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    }
}
