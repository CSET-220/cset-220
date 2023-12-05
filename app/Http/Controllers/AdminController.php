<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Patient;
use Carbon\Carbon;
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
            elseif($role == 'patient'){
                Patient::where("user_id", $approved_id)->update(['admission_date' => date('Y-m-d')]);
            }
        }
        if($denied_id){
            $deniedPatientID = Patient::where('user_id', $denied_id)->value('id');
            Patient::destroy($deniedPatientID);
            User::destroy($denied_id);
        }
    }

    public function show(User $admin){
        if (Auth::check()) {
            if (auth()->user()->getAccess(['admin'])) {
                return view('admin.home');
            }
            else{
                return redirect()->back();
            }
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
