<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\PatientController;


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
Route::get('/' ,[loginController::class ,'home'])->name('app.home');


Route::get('/', [loginController::class , 'home'])->name('app.home');
Route::resource('/rosters', RosterController::class);
Route::get('/patients/{id}/logs', [PatientController::class, 'logs'])->name('patients.logs');
Route::resource('/patients', PatientController::class);
