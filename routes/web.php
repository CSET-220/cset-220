<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\RosterController;
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

// TODO: remove when done with patient page
// Route::get('/', function() {
//     return view('patients/index');
// });

Route::get('/', [loginController::class , 'home'])->name('app.home');

Route::resource('rosters', RosterController::class);