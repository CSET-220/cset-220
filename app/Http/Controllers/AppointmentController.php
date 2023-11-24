<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function show(string $patient_id)
    {
        if(Auth::check() && Auth::user()->getAccess(['doctor','admin','supervisor'])){
            $appointments = Appointment::where('patient_id', $patient_id )->where('doctor_id', Auth::id())->orderByDesc('date')->paginate(2);
            return response()->json($appointments);
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }


    public function conductAppointment(Request $request, string $id){
        // dd('ROUTE HIT');
        if(Auth::check() && Auth::user()->getAccess(['doctor'])){

            // if any field is null
            $morningPrescription = $request->morning_prescription_id;
            $afternoonPrescription = $request->afternoon_prescription_id;
            $nightPrescription = $request->night_prescription_id;
            $comment = $request->comment;


            Appointment::where('id',$id)->update(['morning_med' => $morningPrescription,'afternoon_med' => $afternoonPrescription, 'night_med' => $nightPrescription, 'comments' => $comment]);
            return redirect()->route('employees.show',['employee' => Auth::id()])->with('appointment_success', 'Appointment Completed');
            // put appointment success in blade
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }

    public function edit($id){

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
