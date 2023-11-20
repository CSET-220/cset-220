<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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
        if(Auth::user()->getAccess(['supervisor'])){

        }
        elseif (Auth::user()->getAccess(['doctor'])) {
            // if the request was an ajax request 
            if ($request->ajax()) {
                $appointments = Appointment::with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])
                    ->where('doctor_id', Auth::id())
                    ->select(['appointments.*', 'users.first_name', 'users.last_name'])->orderByDesc('date')
                    ->get();
                // Return custom datatable
                return DataTables::of($appointments)->make(true);
            }
    
            // Non-AJAX request return regular view
            $appointments = Appointment::with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])
                ->where('doctor_id', Auth::id())
                ->get();
            
            return view('doctors.doctorHome', ['appointments' => $appointments]);
            
        }
        elseif (Auth::user()->getAccess(['caregiver'])) {
            # code...
        }
        else{
            redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }


    public function search(Request $request)
    {
        // ORIGINAL QUERY TO GET ALL APPOINTMENTS BY DOCTOR
        $query = Appointment::query();
        $query->with(['patient.user', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])->where('doctor_id', Auth::id());
    
        $columnName = $request->columnName;
        $searchValue = $request->searchValue;
        
        // Search and filter
        if ($columnName && $searchValue) {
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
