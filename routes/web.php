<?php

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ContactsController;
use App\Http\Controllers\Pages\HelpController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\RoadmapController;

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\CenterController;
use App\Http\Controllers\Account\ProcedureController;
use App\Http\Controllers\Account\AppointmentController;
use App\Http\Controllers\Account\BillingController;
use App\Http\Controllers\Account\ChatController;
use App\Http\Controllers\Account\DocumentController;
use App\Http\Controllers\Account\LocaleController;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Account\PatientController;
use App\Http\Controllers\Account\ScheduleController;
use App\Http\Controllers\Account\TreatmentController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProcedureController as AdminProcedureController;
use App\Http\Controllers\Admin\CenterController as AdminCenterController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\WardController as AdminWardController;

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
    Route::post('/locale', [LocaleController::class, 'locale'])->name('locale');
    
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
        Route::group(['prefix' => 'account'], function () {
            Route::get('/', [AccountController::class, 'index'])->name('account.index');
            Route::post('/', [AccountController::class, 'update'])->name('account.update');

            Route::get('/chat', [ChatController::class, 'index'])->name('account.chat');

            Route::get('/centers', [CenterController::class, 'index'])->name('account.center');
            Route::get('/centers/{id}', [CenterController::class, 'show'])->name('account.center.show');
            Route::post('/centers', [CenterController::class, 'store'])->name('account.center.store');

            Route::get('/procedures', [ProcedureController::class, 'index'])->name('account.procedure');
            Route::post('/procedures', [ProcedureController::class, 'store'])->name('account.procedure.store');

            Route::get('/appointments', [AppointmentController::class, 'index'])->name('account.appointment');
            Route::post('/appointments', [AppointmentController::class, 'store'])->name('account.appointment.store');

            Route::get('/patients', [PatientController::class, 'index'])->name('account.patient');

            Route::get('/treatments', [TreatmentController::class, 'index'])->name('account.treatment');

            Route::get('/billing', [BillingController::class, 'index'])->name('account.billing');

            Route::get('/documents', [DocumentController::class, 'index'])->name('account.document');

            Route::get('/medcard', [DocumentController::class, 'medcard'])->name('account.document.medcard');
            Route::get('/medcard/{id}', [DocumentController::class, 'showMedcard'])->name('account.document.medcard.show');
            Route::post('/medcard/{id}', [DocumentController::class, 'storeMedcard'])->name('account.document.medcard.store');

            Route::get('/intake', [DocumentController::class, 'intake'])->name('account.document.intake');
            Route::get('/intake/{id}', [DocumentController::class, 'showIntake'])->name('account.document.intake.show');
            Route::post('/intake/{id}', [DocumentController::class, 'storeIntake'])->name('account.document.intake.store');

            Route::get('/diagnosis', [DocumentController::class, 'diagnosis'])->name('account.document.diagnosis');

            Route::get('/schedule', [ScheduleController::class, 'index'])->name('account.schedule');

            Route::get('/notifications', [NotificationController::class, 'index'])->name('account.notification');
            Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('account.notification.read');
        });
        // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
        // Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::group(['prefix' => 'centers'], function () {
            Route::get('/', [AdminCenterController::class, 'index'])->name('admin.center.index');
            Route::post('/', [AdminCenterController::class, 'store'])->name('admin.center.store');
            Route::put('/{id}', [AdminCenterController::class, 'update'])->name('admin.center.update');
            Route::delete('/{id}', [AdminCenterController::class, 'delete'])->name('admin.center.delete');
        });
        Route::group(['prefix' => 'procedures'], function () {
            Route::get('/', [AdminProcedureController::class, 'index'])->name('admin.procedure.index');
            Route::post('/', [AdminProcedureController::class, 'store'])->name('admin.procedure.store');
            Route::put('/{id}', [AdminProcedureController::class, 'update'])->name('admin.procedure.update');
            Route::delete('/{id}', [AdminProcedureController::class, 'delete'])->name('admin.procedure.delete');
        });
        Route::group(['prefix' => 'departments'], function () {
            Route::get('/', [AdminDepartmentController::class, 'index'])->name('admin.department.index');
            Route::post('/', [AdminDepartmentController::class, 'store'])->name('admin.department.store');
            Route::put('/{id}', [AdminDepartmentController::class, 'update'])->name('admin.department.update');
            Route::delete('/{id}', [AdminDepartmentController::class, 'delete'])->name('admin.department.delete');
        });
        Route::group(['prefix' => 'patients'], function () {
            Route::get('/', [AdminPatientController::class, 'index'])->name('admin.patient.index');
            Route::post('/', [AdminPatientController::class, 'store'])->name('admin.patient.store');
            Route::put('/{id}', [AdminPatientController::class, 'update'])->name('admin.patient.update');
            Route::delete('/{id}', [AdminPatientController::class, 'delete'])->name('admin.patient.delete');
        });
        Route::group(['prefix' => 'staff'], function () {
            Route::get('/', [AdminStaffController::class, 'index'])->name('admin.staff.index');
            Route::post('/', [AdminStaffController::class, 'store'])->name('admin.staff.store');
            Route::put('/{id}', [AdminStaffController::class, 'update'])->name('admin.staff.update');
            Route::delete('/{id}', [AdminStaffController::class, 'delete'])->name('admin.staff.delete');
        });
        Route::group(['prefix' => 'appointments'], function () {
            Route::get('/', [AdminAppointmentController::class, 'index'])->name('admin.appointment.index');
            Route::post('/', [AdminAppointmentController::class, 'store'])->name('admin.appointment.store');
            Route::put('/{id}', [AdminAppointmentController::class, 'update'])->name('admin.appointment.update');
            Route::delete('/{id}', [AdminAppointmentController::class, 'delete'])->name('admin.appointment.delete');
        });
        Route::group(['prefix' => 'wards'], function () {
            Route::get('/', [AdminWardController::class, 'index'])->name('admin.ward.index');
            Route::post('/', [AdminWardController::class, 'store'])->name('admin.ward.store');
            Route::put('/{id}', [AdminWardController::class, 'update'])->name('admin.ward.update');
            Route::delete('/{id}', [AdminWardController::class, 'delete'])->name('admin.ward.delete');
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
