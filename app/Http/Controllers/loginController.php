<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function home(){
        return view('home.home');
    }

    public function login(Request $request){
        // dd($request);

        $credentials = $request->validate(
            [
                'email' => 'required|exists:users,email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Please enter valid Email',
                'email.exists' => 'That email is not linked to an account',
                'password.required' => 'Please enter a password'
            ]
    
        );
        // remember me checkbox
        $remember = ($request->has('remember')) ? true : false;


        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password, 'is_approved' => 1], $remember )){
            $user = Auth::user();
            if($user->getAccess(['admin'])){
                return redirect()->route('admin.show',['admin' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['supervisor'])) {
                return redirect()->route('employees.show',['employee' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['doctor'])) {
                return redirect()->route('employees.show',['employee' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['caregiver'])) {
                return redirect()->route('employees.show',['employee' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['family'])) {
                return redirect()->route('patients.show',['patient' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['patient'])) {
                return redirect()->route('patients.show',['patient' => Auth::user()])->with('login_success','Login Successful');
            }
        }
        else{
            return redirect()->back()->withErrors([
                'email' => 'You must be approved before you can login.'
            ]);
        }

    }
}
