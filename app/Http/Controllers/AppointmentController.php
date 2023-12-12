<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Displays all previous appointments between doctor and patient and date of appt
    // gets patient and doctor information from appointments to display previous appointments
    // and patient information to schedule new appointment
    // link in navbar of admin and supervisor as Schedule Appointment
    public function index()
    {
        if(Auth::check() && Auth::user()->getAccess(['admin','supervisor'])){
            $patients = Patient::where('admission_date', '<=', date('Y-m-d'))->get();
            return view('appointments.allAppointments', [ 'patients' => $patients]);

        }
        else{
            return redirect()->route('app.home')->with('access_error', "You do not have permission to view this page");
        }
    }

    public function getAppointmentDay(){
        if(Auth::check() && Auth::user()->getAccess(['admin','supervisor'])){
            $appointments = Appointment::with([
                'patient.user' => function ($query){
                    $query->select(['id', 'first_name', 'last_name']);
                }, 
                'doctor' => function ($query){
                    $query->select(['id','first_name', 'last_name']);
                }
            ])->select(['id','date', 'patient_id', 'doctor_id'])->orderBy('date', 'asc')->get()->groupBy(function ($appointment) { //where('date', '>=', date('Y-m-d'))->
                return $appointment->date;
            });
            return response()->json($appointments);
        }
    }
    public function getDrOnShift(Request $request){
        $aptDate = $request->apt_date;
        // dd($aptDate);
        $doctors = Roster::with('doctor')->where('date', $aptDate)->get();
        return response()->json($doctors);
    }

    public function create(){

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'apt_date' => 'required|date|after_or_equal:today',
            'doctor_id' => 'required|numeric|exists:rosters,doctor_id'
        ],
        [
            'apt_date.after_or_equal' => 'The Appointment Date Must Be After Today'
        ]
    );

        $unique = Appointment::where('patient_id', $request->patient_id)->where('date',$request->apt_date)->first();
        if($unique){
            return redirect()->back()->withErrors([
                'patient_id' => 'Patient already has an appointment on that day'
            ]);
        }

        // dd($request->patient_id);

        Appointment::create(['patient_id' => $request->patient_id, 'date' => $request->apt_date, 'doctor_id' => $request->doctor_id]);
        return redirect()->route('appointments.index')->with('appointment_success', 'Appointment Scheduled Successfully');
    }

    /**
     * Display the specified resource.
     */

    // Shows all appointments for a specific patient on doctors page
    public function show(string $patient_id)
    {
        if(Auth::check() && Auth::user()->getAccess(['doctor'])){
            $appointments = Appointment::where('patient_id', $patient_id )->where('doctor_id', Auth::id())->orderByDesc('date')->paginate(2);
            return response()->json($appointments);
        }
        elseif (Auth::check() && Auth::user()->getAccess(['admin','supervisor'])) {
            $appointments = Appointment::with(['patient.user', 'doctor'])->select(['id','date', 'patient_id', 'doctor_id'])->where('patient_id',$patient_id)->orderBy('date','desc')->get();
            return response()->json($appointments);
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }

    // Updates the appointment table columns (time)_med and comments for doctors
    public function conductAppointment(Request $request, string $id){
        // dd('ROUTE HIT');
        if(Auth::check() && Auth::user()->getAccess(['doctor'])){

            // if any field is null
            $morningPrescription = $request->morning_prescription_id;
            $afternoonPrescription = $request->afternoon_prescription_id;
            $nightPrescription = $request->night_prescription_id;
            $comment = $request->comment;
            $patient_id = Appointment::where('id', $id)->pluck('patient_id')[0];
            $justPrescribed = [$morningPrescription,$afternoonPrescription,$nightPrescription];
            $newRx = $this->anyNewRx($patient_id,$justPrescribed);
            $rxPrice = $newRx * 5;
            $apt_price = $rxPrice + 50;
            // dd($apt_price);
            Patient::where('id', $patient_id)->increment('balance', $apt_price);
            Appointment::where('id',$id)->update(['morning_med' => $morningPrescription,'afternoon_med' => $afternoonPrescription, 'night_med' => $nightPrescription, 'comments' => $comment]);
            return redirect()->route('employees.show',['employee' => Auth::id()])->with('appointment_success', 'Appointment Completed');
            // put appointment success in blade
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }


    public function anyNewRx($patient_id, array $justPrescribed){
        // $justPrescribed = [$request->morning_prescription_id,$request->afternoon_prescription_id,$request->night_prescription_id]
        $justPrescribed = array_unique($justPrescribed);
        // get all new prescriptions from the 1st til now
        $now = Carbon::now();
        $monthFirst = Carbon::now()->startOfMonth();
        $prescriptions = Prescription::join('appointments', function ($join) {
            $join->on('appointments.morning_med', '=', 'prescriptions.id')
                ->orOn('appointments.afternoon_med', '=', 'prescriptions.id')
                ->orOn('appointments.night_med', '=', 'prescriptions.id');
        })
        ->where('appointments.patient_id', $patient_id)
        ->whereBetween('appointments.date', [$monthFirst, $now])
        ->select('prescriptions.*')
        ->distinct()
        ->get();
        $allRx = $prescriptions->pluck('id')->toArray();
        // Counts any new rx and multiplied by 5 before added to patient balance
        $newRx = 0;
        foreach ($justPrescribed as $rx) {
            if(isset($rx) && !in_array($rx,$allRx)){
                $newRx++;
            }
        }
        return $newRx;
    }

    public function edit($id){

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::check() && Auth::user()->getAccess(['supervisor', 'admin'])){
            // Reschedule Appointment
            $request->validate(
                [
                    'apt_date' => 'required',
                    'doctor_id' => 'required',
                ],
                [
                    'apt_date.required' => 'Please Enter a Reschedule Date',
                    'doctor_id' => 'No Doctors Available'
                ]
            );
            $patientId = $request->patient_id;
            $aptDate = $request->apt_date;
            $doctorId = $request->doctor_id;
    
            $unique = Appointment::where('patient_id',$patientId)->where('date', $aptDate)->where('id', '!=', $id)->first();
            if($unique){
                return response()->json(['apt_date' => 'Patient already has an appointment that day'], 422);
            }


            Appointment::where('id',$id)->update(['date' => $aptDate, 'doctor_id' => $doctorId]);
            return response()->json(['reschedule_success' => 'Appointment Rescheduled Successfully']);
            // return redirect()->route('appointments.index')->with('appointment_change_success', 'Appointment Canceled');
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::check() && Auth::user()->getAccess(['admin','supervisor'])){
            Appointment::destroy($id);
            return redirect()->route('appointments.index')->with('appointment_change_success', 'Appointment Canceled');
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }

    }
}
