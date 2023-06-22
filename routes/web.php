<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\BanlanceController;

//URL::forceScheme('https');

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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware(['auth'])->name('dashboard');
Route::post('/ajax', [BetController::class, 'showAjax'])->middleware(['auth']);
Route::get('/profile', [ProfileController::class, 'showProfile'])->middleware(['auth'])->name('profile');


require __DIR__.'/auth.php';

Route::get('/{pageNotFound1}', [BanlanceController::class, 'show']);
