<?php

use App\Http\Controllers\CommitteeController;
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
// !resource
Route::resource('users', UserController::class);
Route::resource('committees', CommitteeController::class);
