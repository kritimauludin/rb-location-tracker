<?php

use App\Http\Controllers\AjaxRequestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DistributionController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify' => true
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('/my-profile', [App\Http\Controllers\HomeController::class, 'myProfile'])->name('my-profile')->middleware('verified');

Route::post('/promote', [UserController::class, 'promote'])->middleware('auth');

// Route resource controller
Route::resource('user', UserController::class)->middleware('auth');
Route::resource('customer', CustomerController::class)->middleware('auth');
Route::resource('distribution', DistributionController::class)->middleware('auth');

//generate new code
Route::get('/getnewcode', [AjaxRequestController::class, 'getNewCode'])->middleware('auth');
