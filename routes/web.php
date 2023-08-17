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
Route::get('/', [GeneralController::class, 'landingPage'])->name('/')->middleware('guest');

Auth::routes([
    'verify' => true
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('/my-profile', [App\Http\Controllers\HomeController::class, 'myProfile'])->name('my-profile')->middleware('verified');

Route::post('/promote', [UserController::class, 'promote'])->middleware('auth');

// Route resource controller
Route::resource('user', UserController::class)->middleware('auth');
Route::resource('newspaper', NewspaperController::class)->middleware('auth');


Route::get('/customer/generate-report', [CustomerController::class,'generateReport'])->middleware('auth');
Route::resource('customer', CustomerController::class)->middleware('auth');

Route::get('/distribution/print', [DistributionController::class,'print'])->middleware('auth');
Route::get('/distribution/today', [DistributionController::class, 'todayDistribution'])->middleware('auth')->name('distribution.today');
Route::get('/distribution/update-status', [DistributionController::class, 'updateStatus'])->middleware('auth')->name('distribution.update-status');
Route::get('/distribution/report', [DistributionController::class, 'reportDistribution'])->middleware('auth')->name('distribution.report');
Route::resource('distribution', DistributionController::class)->middleware('auth');

//generate new code
Route::get('/getnewcode', [AjaxRequestController::class, 'getNewCode'])->middleware('auth');


