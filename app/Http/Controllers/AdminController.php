<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Support\Carbon;
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
} 
