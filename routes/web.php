<?php

use App\Http\Controllers\Admin\GeofenceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Livewire\MapPage;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {


    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/get-total-distance/{days}', [DashboardController::class, 'getAvgTotalDistance'])->name('get-avg-total-distance');
//    Route::get('/', function () {
//        if (session('warning-alert')) {
//            $user = Auth::user();
//            return redirect('/map')->with('warning-alert', "{$user->name} عزیز خوش آمدید!\nبرای شروع کار با حساب کاربری جدید خود، لطفاً رمز عبور اولیه خود را با یک رمز عبور قوی و امن جایگزین کنید.\nبرای تغییر رمزعبور، می‌توانید به بخش مدیریت حساب خود مراجعه کنید.");
//        } else {
//            return redirect('/map');
//        }
//    })->name('home');

    Route::get('/map', MapPage::class)->name('map');

    Route::resource('device', DeviceController::class);
    Route::get('/device/device-setting/{device}', [DeviceController::class, 'deviceSetting'])->name('device.device-setting');
    Route::post('/device/store-sms/{device}', [DeviceController::class, 'storeSMS'])->name('device.store-sms');
    Route::get('/device/change-status/{device}', [DeviceController::class, 'changeStatus'])->name('device.change-status');
//    Route::get('/device/get-location/{id}', [DeviceController::class, 'location'])->name('device.get-location');

    Route::resource('vehicle', VehicleController::class);
    Route::get('/vehicle/change-status/{vehicle}', [VehicleController::class, 'changeStatus'])->name('vehicle.change-status');

    Route::resource('user', UserController::class);
    Route::get('/user/change-status/{user}', [UserController::class, 'changeStatus'])->name('user.change-status');

    Route::resource('company', CompanyController::class);
    Route::delete('company/remove-subsets/{company}/{id}', [CompanyController::class, 'removeSubsets'])->name('company.remove-subsets');
    Route::get('company/manage-subsets/{company}', [CompanyController::class, 'manageSubsets'])->name('company.manage-subsets');
    Route::get('/company/change-status/{company}', [CompanyController::class, 'changeStatus'])->name('company.change-status');

    Route::resource('geofence', GeofenceController::class);
    Route::get('/geofence/change-status/{geofence}', [GeofenceController::class, 'changeStatus'])->name('geofence.change-status');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::get('/forgot-password', [ProfileController::class, 'forgotPassword'])->name('forgot-password');
    });

});


require __DIR__ . '/auth.php';
