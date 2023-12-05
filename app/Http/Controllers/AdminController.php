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
    public function index(User $admin){
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

    public function show(User $admin){

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
} 
