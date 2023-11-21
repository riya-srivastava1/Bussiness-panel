<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\DisabledDateController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\VendorProfileController;
use App\Http\Controllers\VendorServiceController;
use App\Http\Controllers\ManageCalenderController;
use App\Http\Controllers\Business\DisabledTimeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('dashboard/user/booking', [BusinessController::class, 'userBooking'])->name('dashboard.user.booking');
Route::get('dashboard/my-account', [BusinessController::class, 'myAccount'])->name('dashboard.myaccount');
Route::get('business/dashboard', [BusinessController::class, 'dashboard'])->name('business.dashboard');
Route::get('amenities', [BusinessController::class, 'amenities'])->name('amenities');
Route::get('vendor/time-management', [BusinessController::class,'timeManageView'])->name('vendor.time.management');
Route::get('dashboard/add-branch', [BusinessController::class,'addBranch'])->name('vendor.add.branch')->middleware('branchAuth');



Route::get('user/total-booking/{vendor_id}', [UserBookingController::class, 'totalBooking'])->name('user.total.booking');

Route::get('user/cash-payment/{vendor_id}', [UserBookingController::class, 'cashPayment'])->name('user.cash.booking');

Route::get('dashboard/user/booking/details', [BusinessController::class, 'userBookingDetails'])->name('business.dashboard.user.booking.details');

Route::patch('vendor/profile/update/{id}', [VendorProfileController::class, 'update'])->name('vendor.profile.update');
Route::patch('vendor/profile/update/address/{id}', [VendorProfileController::class, 'updateAddress'])->name('vendor.profile.update.address');
Route::patch('vendor/profile/update/bank/{id}', [VendorProfileController::class, 'updateBank'])->name('vendor.profile.update.bank');
Route::post('vendor/profile/update/banner', [VendorProfileController::class, 'uploadBannerImage'])->name('vendor.profile.update.banner');
Route::post('vendor/profile/update/logo', [VendorProfileController::class, 'uploadLogoImage'])->name('vendor.profile.update.logo');
Route::post('vendor/profile/update/pan', [VendorProfileController::class, 'uploadPanImage'])->name('vendor.profile.update.pan');
Route::post('vendor/profile/update/business-certificate', [VendorProfileController::class, 'uploadBusinessCertificateImage'])->name('vendor.profile.update.business.certificate');
Route::patch('vendor/profile/update/amenity/{id}', [VendorProfileController::class, 'updateAmenity'])->name('vendor.profile.update.amenity');


Route::get('dashboard/services/{vendor_id?}', [VendorServiceController::class,'services'])->name('business.dashboard.services');
Route::get('vendor/service/create', [VendorServiceController::class,'create'])->name('vendor.service.create');
Route::post('vendor/service/store', [VendorServiceController::class,'store'])->name('vendor.service.store');
Route::get('vendor/service/edit/{id}', [VendorServiceController::class,'edit'])->name('vendor.service.edit');
Route::patch('vendor/service/update/{id}', [VendorServiceController::class,'update'])->name('vendor.service.update');
Route::get('vendor/service/update/status/{id}', [VendorServiceController::class,'updateStatus'])->name('vendor.service.update.status');
Route::delete('vendor/service/destroy/{id}', [VendorServiceController::class,'destroy'])->name('vendor.service.destroy');
// Route::get('vendor/service/destroy/{id}', [VendorServiceController::class,'destroy'])->name('vendor.service.destroy');
Route::get('vendor/service/destroy/{id}', [VendorServiceController::class,'destroy'])->name('vendor.services.destroy');


Route::get('export/vendor-service', [ImportExportController::class,'export'])->name('export.vendor.service')->middleware('businessAuth');


//Date Time Management
Route::post("vendor/time-management/disable-date", [DisabledDateController::class,'disabledDateFun'])->name('vendor.date.disabled');
Route::post("vendor/time-management/enable-date", [DisabledDateController::class,'enabledDateFun'])->name('vendor.date.enable');
Route::get("vendor/time-management/getTimeShedule", [DisabledDateController::class,'getTimeShedule'])->name('vendor.get.time.shedule');

Route::post("vendor/time-management/disable-time", [DisabledTimeController::class,'disabledTime'])->name('vendor.time.disabled');
Route::post("vendor/time-management/enable-time", [DisabledTimeController::class,'enableTime'])->name('vendor.time.enable');

Route::post("vendor/time-management/manage-customer-time/storestore", [ManageCalenderController::class,'store'])->name('vendor.manage.customer.store');
Route::post("vendor/time-management/manage-customer-time/update", [ManageCalenderController::class,'update'])->name('vendor.manage.customer.update');

Route::get('dashboard/branch', [BusinessController::class,'branch'])->name('vendor.branch')->middleware('branchAuth');
Route::post('dashboard/branch/edit-permisssion', [BusinessController::class,'updateEditPermission'])->name('vendor.branch.edit.permission')->middleware('branchAuth');


require __DIR__ . '/auth.php';
