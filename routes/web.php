<?php

use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProcedureController as AdminProcedureController;
use App\Http\Controllers\Pages\ContactsController;
use App\Http\Controllers\Pages\HelpController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\RoadmapController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/', [HomeController::class, 'index']);
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });

// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/login', [AuthController::class, 'enter'])->name('account.login.enter');
// Route::get('/signup', [AuthController::class, 'signup'])->name('account.signup');
// Route::post('/signup', [AuthController::class, 'store'])->name('account.signup.store');
// Route::post('/logout', [AuthController::class, 'logout'])->name('account.logout');

Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    // Guest middleware
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'enter'])->name('login.enter');
        Route::get('signup', [AuthController::class, 'signup'])->name('signup');
        Route::post('signup', [AuthController::class, 'store'])->name('signup.store');
    });
    // Authenticate middleware
    Route::group(['middleware' => 'auth'], function () {
        Route::get('account', [AccountController::class, 'index'])->name('account');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::group(['prefix' => 'admin'], function () {
    // Guest middleware for admin
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminAuthController::class, 'login'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'enter'])->name('admin.login.enter');
    });
    // Authenticate middleware for admin
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', [AdminDashboardController::class, 'home'])->name('admin.home');
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::group(['prefix' => 'procedures'], function () {
            Route::get('/', [AdminProcedureController::class, 'index'])->name('admin.procedure.index');
            Route::post('/', [AdminProcedureController::class, 'store'])->name('admin.procedure.store');
            // Route::get('/{id}',[AdminProcedureController::class,'edit'])->name('admin.procedure.edit');
            Route::put('/{id}', [AdminProcedureController::class, 'update'])->name('admin.procedure.update');
            Route::delete('/{id}', [AdminProcedureController::class, 'delete'])->name('admin.procedure.delete');
        });
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});

Route::group(['prefix' => 'roadmap'], function () {
    Route::get('patient', [RoadmapController::class, 'patient'])->name('roadmap.patient');
    Route::get('employee', [RoadmapController::class, 'employee'])->name('roadmap.employee');
    Route::get('administrator', [RoadmapController::class, 'admin'])->name('roadmap.admin');
    Route::get('center', [RoadmapController::class, 'center'])->name('roadmap.center');
});
