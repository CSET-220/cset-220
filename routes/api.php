<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;

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
Route::resource('/logs', LogController::class);
Route::resource('/employees', EmployeeController::class);
Route::resource('/appointments', AppointmentController::class);
Route::resource('/admin', AdminController::class);


Route::post('/login', [loginController::class, 'login'])->name('app.login');
Route::get('/logout', [loginController::class, 'logout'])->name('app.logout');

Route::get('/careers', [UserController::class, 'employeeRegister'])->name('employee.register');

Route::post('/doctor/search', [EmployeeController::class, 'search'])->name('doctor.search');



Route::get('/prescriptions/{prescription_name}/dosage',[PrescriptionController::class, 'getDosage'])->name('prescription.dosage');
Route::post('/appointments/{appointment}/conduct', [AppointmentController::class, 'conductAppointment'])->name('appointment.conduct');

Route::get('/appointments/by/day', [AppointmentController::class, 'getAppointmentDay'])->name('appointments.by.day');
Route::get('/appointments/doctor/onShift', [AppointmentController::class, 'getDrOnShift'])->name('doctor.on.shift');
Route::post('/admin/approval', [AdminController::class, 'approval'])->name('admin.approval');

Route::post('/users/{user}/payment', [UserController::class, 'payment'])->name('users.payment');
Route::get('/users/{user}/family/connect', [UserController::class, 'familyCodeSearch'])->name('family.dashboard.connect');
Route::get('/users/{user}/admin/bill/patients', [AdminController::class, 'billPatients'])->name('bill.patients');
Route::post('/updateLog', [LogController::class, 'updateLog'])->name('log.update');
Route::post('/updateSalary', [AdminController::class, 'updateSalary'])->name('admin.updateSalary');
Route::post('/admin/searchEmployee', [AdminController::class, 'searchEmployee'])->name('admin.searchEmployee');
Route::post('/admin/refreshEmployeeTable', [AdminController::class, 'refreshEmployeeTable'])->name('admin.refreshEmployeeTable');
Route::get('/admin/report/all', [AdminController::class, 'adminReport'])->name('admin.adminReport');
Route::get('/patients/{patient_id}/{date}', [PatientController::class, 'getPatientLog']);