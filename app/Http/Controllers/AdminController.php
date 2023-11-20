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
    //
    public function index(){
        if (Auth::check()) {
            if (auth()->user()->getAccess(['admin', 'supervisor'])) {
                $users = User::where('is_approved', 0)->paginate(6);
                return view('admin.reg_approval', compact('users'));
            }
            else{
                return redirect()->back();
            }
        }
    }

    public function reg_approval(Request $request){
        $approve = $request->approve;
        $deny = $request->deny;
        if($approve){
            foreach($approve as $id){
                User::where('id',$id)->update(['is_approved' => 1]);
                $user = User::find($id);
                $role = Role::where('id',$user->role_id)->value('role_title');
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
}
