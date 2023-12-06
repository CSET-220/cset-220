<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        if (Auth::check()) {
            if (auth()->user()->getAccess(['admin', 'supervisor'])) {
                $users = User::where('is_approved', 0)->get();
                return view('admin.approval', compact('users'));
            }
            else{
                return redirect()->back();
            }
        }
    }

    public function approval(Request $request){
        $approved_id = $request->approved_id;
        $denied_id = $request->denied_id;
        if($approved_id){
            User::where('id',$approved_id)->update(['is_approved' => 1]);
            $user = User::where('id', $approved_id)->first();
            $role = Role::where('id',$user->role_id)->first();
            // To do: Add users with created roles to employee table as well - test
            if($role->role_title == 'doctor' || $role->role_title == 'supervisor' || $role->role_title == 'caregiver' || $role->access_level == 4){
                Employee::create(['user_id' => $approved_id]);
            }
            if($role->role_title == 'patient') {
                $patient = Patient::where('user_id', $approved_id)->first();
                $patient->update(['last_billed_date' => now()]);
                $patient->update(['admission_date' => now()]);
            }
        }
        if($denied_id){
            $deniedPatientID = Patient::where('user_id', $denied_id)->value('id');
            Patient::destroy($deniedPatientID);
            User::destroy($denied_id);
        }
    }

    public function show(User $admin){

    }

    public function patientInfo(Request $request, User $admin){
        if (Auth::check()) {
            if (auth()->user()->getAccess(['admin', 'supervisor'])) {
                if ($request->has('patient_id')) {
                    $patient_id = $request->patient_id;
                    $patient = Patient::where('id', $patient_id)->first();
                    $user = User::where('id', $patient->user_id)->first();
                    $patientInfo = array(
                        'patient_name' => $user->first_name . ' ' . $user->last_name,
                        'patient_group' => $patient->patient_group,
                        'admission_date' => $patient->admission_date
                    );
                    if ($user->is_approved == 1) {
                        return view('admin.patientInfo', ['patientInfo' => $patientInfo]);
                    }
                    else{
                        return view('admin.patientInfo');
                    }
                }
                return view('admin.patientInfo');
            }
            else{
                return redirect()->back();
            }
        }
    }

    public function billPatients(){
        if(Auth::check() && Auth::user()->getAccess(['admin'])){
            $patients = Patient::all();
            foreach ($patients as $patient) {
                $today = Carbon::now();
                $lastBilled = $patient->last_billed_date;
                $differenceInDays = $today->diffInDays($lastBilled);
                $amount = $differenceInDays * 10;
    
                $patient->last_billed_date = $today;
                $patient->balance += $amount;
                $patient->save();
    
            }
            return redirect()->route('users.show', ['user' => Auth::user()])->with('bill_success', 'Successfully Billed All Patients');
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to view this page.');
        }
    }

    public function create()
    {
        if(Auth::check()) {
            if(auth()->user()->getAccess(['admin', 'supervisor'])){
                $employees = Employee::all();
                return view('admin.create', compact('employees'));
            }
            else {
                return redirect()->back();
            }
        }
    }

    public function update(Request $request, string $id)
    {

    }

    public function updateSalary(Request $request)
    {
        // TODO validate amount returned from request
        if($request->salary < 0 || !is_numeric($request->salary)) {
            return response()->json(['message' => 'Invalid salary amount']);
        } 
        $employee = Employee::find($request->employeeId);
        if($employee) {
            $employee->salary = $request->salary;
            $employee->save();
            return response()->json([
                'success' => 'Salary updated successfully',
                'newSalary' => $employee->salary
            ]);
        } else {
            return response()->json(['error' => 'Employee not found']);
        }
    }

    public function searchEmployee(Request $request)
    {
        if($request->ajax()) {
            // TODO fix this need to separate first and last name and add salary inputs to the ajax request and to the blade
            $column = $request->columnName;
            $searchInput = $request->searchInput;
            $minSalary = $request->minSalary;
            $maxSalary = $request->maxSalary;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            if($column == 'id') {
                $results = Employee::with(['user', 'user.role'])
                    ->where('id', $searchInput)
                    ->get();
            } else if($column == 'name') {
                $results = Employee::with(['user', 'user.role'])
                    ->whereHas('user', function($query) use ($first_name, $last_name) {
                        $query->where('first_name', 'LIKE', '%' . $first_name . '%')
                            ->where('last_name', 'LIKE', '%' . $last_name . '%');
                    })
                    ->get();
            } else if($column == 'salary') {
                $results = Employee::with(['user', 'user.role'])
                    ->whereBetween('salary', [$minSalary, $maxSalary])->get();
            } else if($column == 'role_title') {
                $results = Employee::with(['user', 'user.role'])
                ->whereHas('user.role', function ($query) use ($searchInput) {
                    $query->where('role_title', 'LIKE', '%' . $searchInput . '%');
                })
                ->get();
            }
            if($results->isEmpty()) {
                return response()->json(['message' => 'No results found']);
            } else {
                return response()->json(['results' => $results]);
            }
        }
    }

    public function refreshEmployeeTable(Request $request)
    {
        if($request->ajax()) {
            $results = Employee::with(['user', 'user.role'])->get();
            return response()->json(['results' => $results]);
        }
    }

    public function adminReport() 
    {
        if(Auth::check()) {
            if(auth()->user()->getAccess(['admin', 'supervisor'])) {
                $today = Carbon::today()->toDateString();
                $patients = Patient::with(['logs', 'appointments'])->get();
                $patientData = [];
                foreach($patients as $patient) {
                    $missedCareLogs = $patient->logs()
                    ->PatientMissedCare($patient->id, $today)
                    ->get()
                    ->keyBy('date');

                    $missedAppointments = $patient->appointments()
                    ->PatientMissedAppointment($patient->id, $today)
                    ->get()
                    ->keyBy('date');

                    $dates = collect($missedCareLogs->keys())->merge($missedAppointments->keys())->unique()->sort();

                    foreach($dates as $date) {
                        $log = $missedCareLogs->get($date);
                        $appointment = $missedAppointments->get($date);

                        $patientData[$patient->id][$date] = [
                            'log' => $log,
                            'appointment' => $appointment
                        ];
                    }
                } 
                // dd($patientData);
                return view('admin.report', compact('patientData'));
            } else {
                return redirect()->back();
            }
        }
    }
} 
