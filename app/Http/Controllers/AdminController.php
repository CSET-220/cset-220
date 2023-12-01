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
        $approve = $request->approve;
        $deny = $request->deny;
        if($approve){
            foreach($approve as $id){
                User::where('id',$id)->update(['is_approved' => 1]);
                $user = User::find($id);
                $role = Role::where('id',$user->role_id)->value('role_title');
                // Modify if statement to include new roles
                if($role == 'doctor' || $role == 'supervisor' || $role == 'caregiver'){
                    $employee = new Employee;
                    $employee->user_id = $id;
                    $employee->save();
                }
            }
        }
        if($deny){
            foreach($deny as $id){
                User::destroy($id);
            }
        }
        return redirect()->back();
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
            if(auth()->user()->getAccess(['admin']) || auth()->user()->getAccess(['supervisor'])){
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

} 
