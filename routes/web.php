<?php

use App\Http\Controllers\AjaxRequestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewspaperController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GeneralController::class, 'landingPage'])->middleware('guest');

Auth::routes([
    'verify' => true
]);

Route::get('/my-profile', [App\Http\Controllers\HomeController::class, 'myProfile'])->name('my-profile')->middleware('verified');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');
Route::put('/update-profile/{user:user_code}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update-profile');


//Can access with user : auth, verified and role courier
Route::group(['middleware' => ['auth', 'verified', 'courier']], function () {
    Route::get('/distribution/today', [DistributionController::class, 'todayDistribution'])->name('distribution.today');
    Route::get('/distribution/report', [DistributionController::class, 'reportDistribution'])->name('distribution.report');
    Route::get('/distribution/update-status', [DistributionController::class, 'updateStatus'])->name('distribution.update-status');
});


//Can access with user : auth, verified and role superadmin or admin
Route::group(['middleware' => ['auth', 'verified', 'superadmin-admin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/promote', [UserController::class, 'promote']);

    // Route for user controller
    Route::get('/courier/print-performence', [UserController::class, 'printPerformence']);
    Route::resource('user', UserController::class);

    //Route for newspaper controller
    Route::resource('newspaper', NewspaperController::class);

    //Route for customer controller
    Route::get('/customer/generate-report', [CustomerController::class, 'generateReport']);
    Route::resource('customer', CustomerController::class);

    //Route for distribution alocation controller
    Route::get('/distribution/print', [DistributionController::class, 'print']);
    Route::get('/distribution/auto-generate-today', [DistributionController::class, 'autoGenerateDistribution']);
    Route::resource('distribution', DistributionController::class);

    // ajax routes grup
    Route::get('/add-courier-handle', [AjaxRequestController::class, 'addCourierHandle']); //add courier handle
    Route::get('/unhandle-courier', [AjaxRequestController::class, 'unhandleCourier']); //delete courier handle
    Route::get('/getnewcode', [AjaxRequestController::class, 'getNewCode']); //generate new code

});
