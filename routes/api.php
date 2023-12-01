<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/users', UserController::class);
Route::resource('/rosters', RosterController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/prescriptions', PrescriptionController::class);
Route::resource('/patients', PatientController::class);
Route::resource('/logs', LogController::class);
Route::resource('/employees', EmployeeController::class);
Route::resource('/appointments', AppointmentController::class);
Route::resource('/admin', AdminController::class);


Route::post('/login', [loginController::class, 'login'])->name('app.login');
Route::get('/logout', [loginController::class, 'logout'])->name('app.logout');

Route::get('/careers', [UserController::class, 'employeeRegister'])->name('employee.register');

Route::post('/doctor/search', [EmployeeController::class, 'search'])->name('doctor.search');
Route::post('/updateLog', [LogController::class, 'updateLog'])->name('log.update');
Route::post('/updateSalary', [AdminController::class, 'updateSalary'])->name('admin.updateSalary');
Route::post('/admin/searchEmployee', [AdminController::class, 'searchEmployee'])->name('admin.searchEmployee');


Route::get('/prescriptions/{prescription_name}/dosage',[PrescriptionController::class, 'getDosage'])->name('prescription.dosage');
Route::post('/appointments/{appointment}/conduct', [AppointmentController::class, 'conductAppointment'])->name('appointment.conduct');
Route::post('/admin/approval', [AdminController::class, 'approval'])->name('admin.approval');