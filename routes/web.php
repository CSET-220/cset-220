<?php

use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\loginController;
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
Route::get('/', [loginController::class , 'home'])->name('app.home');
Route::get('/patients/{id}/logs', [PatientController::class, 'logs'])->name('patients.logs');
Route::resource('/patients', PatientController::class);
Route::get('/family/logs/{patient_id}', [FamilyController::class, 'logs'])->name('family.logs');
Route::resource('/family', FamilyController::class);