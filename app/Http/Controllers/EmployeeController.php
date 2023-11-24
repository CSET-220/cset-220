<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
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
    public function show(Request $request, string $id)
    {
        if(Auth::check() && Auth::user()->getAccess(['supervisor'])){

        }

        // if user is logged in and a doctor
        elseif (Auth::check() && Auth::user()->getAccess(['doctor'])) {
            // kept displaying 1 day ahead
            date_default_timezone_set('America/New_York');
            // current date and date one week from now formatted to display in datepicker
            $start_date = date('m/d/Y', time());
            $end_date = date('m/d/Y', strtotime('+1 week'));
            // save to session to add value to datepicker inputs with old()
            session(['start_date' => $start_date]);
            session(['end_date' => $end_date]);

            // if the request was an ajax request 
            if ($request->ajax()) {
                // If the request has either changed update the start_date and end_date
                if ($request->start_date && $request->end_date) {
                    $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->start_date)));
                    $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->end_date)));
                }

                $appointments = Appointment::with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])
                    ->where('doctor_id', Auth::id())
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();
                // Return custom datatable
                return DataTables::of($appointments)->make(true);
            }

            // Non-AJAX request return regular view
            $appointments = Appointment::with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])
                ->where('doctor_id', Auth::id())
                ->whereBetween('date', [$start_date, $end_date])
                ->orderBy('date', 'desc')
                ->get();
                // dd($appointments);
            
            return view('doctors.doctorHome', ['appointments' => $appointments]);

        }

        elseif (Auth::check() && Auth::user()->getAccess(['caregiver'])) {
            # code...
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }


    public function search(Request $request)
    {
        // ORIGINAL QUERY TO GET ALL APPOINTMENTS BY DOCTOR
        $query = Appointment::with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])
        ->where('doctor_id', Auth::id());
        
        
        
        $columnName = $request->columnName;
        $searchValue = $request->searchValue;
        //  to tell if searching or not to disregard date filters
        $isSearch = !empty($columnName) && !empty($searchValue);
        
        // if they arent searching apply date filter
        if (!$isSearch) {
            $start_date = $request->input('start_date'); 
            $end_date = $request->input('end_date'); 
            $start_date = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

            // date filter
            $query->whereBetween('date', [$start_date, $end_date]);
        }
        
        // Search
        if($isSearch){
            if (!empty($columnName) && !empty($searchValue)) {
                // dd($searchValue);
                if($columnName === 'name'){
                    $query->whereHas('patient.user', function ($subQuery) use ($searchValue) {
                        $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchValue}%"]);
                    });
                    // dd($query);
                }
                elseif ($columnName === 'morning_med') {
                    $query->where(function ($subQuery) use ($searchValue) {
                        $subQuery->whereHas('morningPrescriptions', function ($morningSubQuery) use ($searchValue) {
                            $morningSubQuery->where('medication_name', 'like', "%{$searchValue}%")
                                        ->orWhere('medication_dosage', 'like', "%{$searchValue}%");
                        });
                    });
                }
                elseif ($columnName === 'afternoon_med') {
                    $query->where(function ($subQuery) use ($searchValue) {
                        $subQuery->whereHas('afternoonPrescriptions', function ($afternoonSubQuery) use ($searchValue) {
                            $afternoonSubQuery->where('medication_name', 'like', "%{$searchValue}%")
                                        ->orWhere('medication_dosage', 'like', "%{$searchValue}%");
                        });
                    });
                }
                elseif ($columnName === 'night_med') {
                    $query->where(function ($subQuery) use ($searchValue) {
                        $subQuery->whereHas('nightPrescriptions', function ($nightSubQuery) use ($searchValue) {
                            $nightSubQuery->where('medication_name', 'like', "%{$searchValue}%")
                                        ->orWhere('medication_dosage', 'like', "%{$searchValue}%");
                        });
                    });
                }
                else{
                    $query->where($columnName, 'like' ,"%{$searchValue}%");
                }
            }
        }
        // order by
        $order = $request->input('order');
        $columnIndex = $order[0]['column'];
        $columnName = $request->input("columns.$columnIndex.data");
        $columnDirection = $order[0]['dir'];
        if($columnName === 'patient_name'){
            // dd($columnName);
            $query->orderBy(Appointment::select(DB::raw('CONCAT(users.first_name, " ", users.last_name)'))
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->join('users', 'patients.user_id', '=', 'users.id')
                ->whereColumn('appointments.id', 'appointments.id')
                ->limit(1)
                , $columnDirection);
        }
        else{
            $query->orderBy($columnName, $columnDirection);
        }
        
        // var_dump($start_date,$end_date);
        return DataTables::of($query)
            ->addColumn('patient_name', function ($appointment) {
                return $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name;
            })
            ->addColumn('date', function ($appointment) {
                return $appointment->date;
            })
            ->addColumn('comments', function ($appointment) {
                return $appointment->comments;
            })
            ->addColumn('morning_med', function ($appointment) {
                return $appointment->morningPrescriptions ? $appointment->morningPrescriptions->medication_name . '<br>' . $appointment->morningPrescriptions->medication_dosage . 'mg' : 'N/A';
            })
            ->addColumn('afternoon_med', function ($appointment) {
                return $appointment->afternoonPrescriptions ? $appointment->afternoonPrescriptions->medication_name . '<br>' . $appointment->afternoonPrescriptions->medication_dosage . 'mg' : 'N/A';
            })
            ->addColumn('night_med', function ($appointment) {
                return $appointment->nightPrescriptions ? $appointment->nightPrescriptions->medication_name . '<br>' . $appointment->nightPrescriptions->medication_dosage . 'mg' : 'N/A';
            })
            ->rawColumns(['morning_med', 'afternoon_med', 'night_med'])
            ->make(true);

    }
    /**
     * Update the specified resource in storage.
     */
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
