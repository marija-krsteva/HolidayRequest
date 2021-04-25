<?php

use App\Http\Controllers\HolidayRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect('/home');
    }
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class)->except([
        'store', 'show'
    ]);
    Route::resource('holidayRequests', HolidayRequestController::class)->except([
        'show'
    ])->middleware('user.employee');

    Route::get('/users/{user}/relations/', [UserController::class, 'relations'])->name('users.relations');
    Route::post('/users/{user}/relations/update', [UserController::class, 'relationsUpdate'])->name('users.relations.update');
});


Route::get('/test', function () {
    \App\Models\User::sendRequests();
});
