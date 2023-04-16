<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelImageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SettingController;
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
Route::get('/hotels-image/index/{hotelId}', [HotelImageController::class, 'index'])->name('hotels-image.index');
Route::post('/hotels-image/store', [HotelImageController::class, 'store'])->name('hotels-image.store');
Route::delete('/hotels-image/update/{id}', [HotelImageController::class, 'update'])->name('hotels-image.update');
Route::delete('/hotels-image/destroy/{id}', [HotelImageController::class, 'destroy'])->name('hotels-image.destroy');
// !data-table
Route::get('/users/jsontable', [UserController::class, 'jsontable'])->name('users.jsontable');
Route::get('/committees/jsontable', [CommitteeController::class, 'jsontable'])->name('committees.jsontable');
Route::get('/hotels/jsontable', [HotelController::class, 'jsontable'])->name('hotels.jsontable');
Route::get('/hotels-image/jsontable', [HotelImageController::class, 'jsontable'])->name('hotels-image.jsontable');
Route::get('/banners/jsontable', [BannerController::class, 'jsontable'])->name('banners.jsontable');
Route::get('/news/jsontable', [NewsController::class, 'jsontable'])->name('news.jsontable');
// !resource
Route::resource('users', UserController::class);
Route::resource('committees', CommitteeController::class);
Route::resource('hotels', HotelController::class);
Route::resource('banners', BannerController::class);
Route::resource('news', NewsController::class);
Route::resource('settings', SettingController::class);
