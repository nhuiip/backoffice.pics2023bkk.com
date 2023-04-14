<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\HotelController;
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
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// !other route
Route::get('/users/{id}/resetpassword', [UserController::class, 'resetpassword'])->name('users.resetpassword');
// !data-table
Route::get('/users/jsontable', [UserController::class, 'jsontable'])->name('users.jsontable');
Route::get('/committees/jsontable', [CommitteeController::class, 'jsontable'])->name('committees.jsontable');
Route::get('/hotels/jsontable', [HotelController::class, 'jsontable'])->name('hotels.jsontable');
Route::get('/banners/jsontable', [BannerController::class, 'jsontable'])->name('banners.jsontable');
// !resource
Route::resource('users', UserController::class);
Route::resource('committees', CommitteeController::class);
Route::resource('hotels', HotelController::class);
Route::resource('banners', BannerController::class);
