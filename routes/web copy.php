<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientBookingFormController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepresentativeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\RepresentativeLocationController;

Route::middleware(['auth', 'role:representative'])->group(function () {
    Route::get('/representativeDashboard', [RepresentativeLocationController::class, 'index'])->name('representative.location');
    Route::post('/save-location', [RepresentativeLocationController::class, 'store'])->name('representative.location.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/representatives', [RepresentativeController::class, 'index'])->name('representatives.show');
    Route::post('/representatives', [RepresentativeController::class, 'store'])->name('representatives.store');
    Route::put('/representatives/{id}', [RepresentativeController::class, 'update'])->name('representatives.update');
    Route::delete('/representatives/{id}', [RepresentativeController::class, 'destroy'])->name('representatives.destroy');
    Route::get('/representatives/{id}/details', [RepresentativeController::class, 'showRepresentativeDetails'])->name('representatives.details');
    Route::delete('/{id}', [RepresentativeController::class, 'destroyDoctor'])->name('representatives.doctor.destroy');
});


Route::get('/doctorCampaign', [PatientBookingFormController::class, 'doctorCampaign'])->name('patient.form.camp');
Route::post('/doctorCampaign', [PatientBookingFormController::class, 'doctorCampaignStore'])->name('patient.form.camp.store');

Route::get('/', [PatientBookingFormController::class, 'index'])->name('patient.form');
Route::post('/store', [PatientBookingFormController::class, 'store'])->name('patient.form.store');
Route::get('/success', [PatientBookingFormController::class, 'successPage'])->name('success.page');

Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);

Route::get('/run-commands', function () {
    // Remove the public/storage symbolic link if it exists
    if (File::exists(public_path('storage'))) {
        File::delete(public_path('storage'));
    }

    // Clear cached views, routes, and config
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');

    // Recreate the storage symbolic link
    Artisan::call('storage:link');

    return "Commands executed successfully!";
});

Route::get('/migration/rollback', function () {

    Artisan::call('migrate:rollback');

    return "Commands executed successfully!";
});

Route::get('/migration/migrate', function () {

    Artisan::call('migrate');

    return "Commands executed successfully!";
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/patient-count', [DashboardController::class, 'getPatientCount'])->name('dashboard.getPatientCount');

    Route::prefix('forms')->group(function () {
        Route::get('/', function () {
            return view('forms.index');
        })->name('forms');
        Route::get('/edit', function () {
            return view('forms.edit');
        })->name('forms.edit');
    });

    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('services.show');
        Route::post('/', [ServiceController::class, 'store'])->name('services.store');
        Route::post('/{id}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    Route::prefix('doctors')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctors.show');
        Route::get('/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::post('/{id}/general/update', [DoctorController::class, 'generalUpdate'])->name('doctors.general.update');
        Route::post('/{id}/approve', [DoctorController::class, 'approve'])->name('doctors.approve');
        Route::get('/custom', [DoctorController::class, 'customIndex'])->name('doctors.custom.show');
        Route::get('/{id}/calendar', [DoctorController::class, 'showCalendar'])->name('doctors.calendar');
        Route::post('/', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/export', [DoctorController::class, 'export'])->name('doctors.export');
        Route::post('/{id}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        Route::post('/create/upload', [DoctorController::class, 'uploadDoctors'])->name('doctors.create.csv');
        
        
        Route::get('/collaborate', [DoctorController::class, 'collaborateShow'])->name('doctors.collaborate.show');
        Route::post('/collaborate/submit', [DoctorController::class, 'collabFormStore'])->name('doctors.collaborate.store');
        Route::get('/thankyou', [DoctorController::class, 'thankyou'])->name('doctors.collaborate.thankyou');
        
    });


    Route::prefix('patients')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('patients.show');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::delete('/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
        Route::get('/export', [PatientController::class, 'export'])->name('patients.export');
        Route::post('/create/upload', [PatientController::class, 'uploadPatients'])->name('patients.create.csv');
        Route::post('/{id}/general/update', [PatientController::class, 'generalUpdate'])->name('patients.general.update');
        Route::post('/{id}/additional/update', [PatientController::class, 'additionalUpdate'])->name('patients.additional.update');
        Route::post('/{id}/marketing/update', [PatientController::class, 'marketingUpdate'])->name('patients.marketing.update');
        Route::post('/{id}/finance/update', [PatientController::class, 'financeUpdate'])->name('patients.finance.update');
    });
    
    
    Route::get('/get-patients/{doctorId}', [PatientController::class, 'getPatients']);


    Route::post('/generate-receipt', [ReceiptController::class, 'generateReceiptPDF'])->name('receipt.generate');
    Route::get('/receipt', [ReceiptController::class, 'receipt'])->name('receipt.show');


    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupons.show');
        Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::post('/{id}/edit', [CouponController::class, 'update'])->name('coupons.update');
        Route::post('/delete', [CouponController::class, 'destroy'])->name('coupons.destroy');
        Route::post('/', [CouponController::class, 'store'])->name('coupons.store');
    });

    Route::prefix('business/settings')->group(function () {
        Route::get('/', [BusinessSettingController::class, 'index'])->name('business.settings.show');
        Route::post('/general/update', [BusinessSettingController::class, 'generalUpdate'])->name('business.settings.general.update');
        Route::post('/colors/update', [BusinessSettingController::class, 'generalUpdate'])->name('business.settings.colors.update');
        Route::post('/form/update', [BusinessSettingController::class, 'generalUpdate'])->name('business.settings.form.update');
    });

    Route::get('/submissions', function () {
        return view('forms.submissions');
    })->name('submissions');
    
    // Route::match(['get', 'post'], '/register', function () {
    //     abort(403, 'Registration is disabled.');
    // });



    // Representative routes

});
