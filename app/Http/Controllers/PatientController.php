<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        //
    }


    public function create(){

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::check() and auth()->user()->patient->id == $id) {
            $patient = Patient::findOrFail($id);
            $user = User::findOrFail($patient->user_id);
            $log = Log::patientLogSearch(date('Y-m-d'), $id)->first();
            $appointment = Appointment::patientAppointmentSearch(date('Y-m-d'), $id)->first();
    
            return view('patients.show', compact('patient', 'user', 'log', 'appointment'));
        }
        else {
            return abort(401);
        }
    }

    public function getPatientLog(string $patient_id, string $date){
        $log = Log::patientLogSearch($date, $patient_id)->first();
        if ($log) {
            $caregiver = User::nameSearch($log->caregiver_id)->first();
            $caregiver_name = "{$caregiver->first_name} {$caregiver->last_name}";
        }
        else {
            $caregiver_name = null;
        }

        $appointment = Appointment::patientAppointmentSearch($date, $patient_id)->first();
        if ($appointment) {
            $doctor = User::nameSearch($appointment->doctor_id)->first();
            $doctor_name = "{$doctor->first_name} {$doctor->last_name}";
        }
        else {
            $doctor_name = null;
        }

        return response()->json([
            'log' => $log, 
            'caregiver' => $caregiver_name,
            'appointment' => $appointment,
            'doctor' => $doctor_name
        ]);
    }


    public function logs(string $id) {
        if(Auth::check() and auth()->user()->patient->id == $id) {
            $patient = Patient::with(['logs', 'appointments.doctor'])->findOrFail($id);
            return view('patients.logs', compact('patient'));
        }
        else {
            return abort(401);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function edit($id){

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
