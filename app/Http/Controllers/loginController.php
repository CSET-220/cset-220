<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
                'login_email' => 'required|exists:users,email',
                'login_password' => 'required'
            ],
            [
                'login_email.required' => 'Please enter valid Email',
                'login_email.exists' => 'That email is not linked to an account',
                'login_password.required' => 'Please enter a password'
            ]

        );
        // remember me checkbox
        $remember = ($request->has('remember')) ? true : false;


        if(Auth::attempt(['email' =>$request->login_email, 'password' => $request->login_password, 'is_approved' => 1], $remember )){
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
                'login_email' => 'You must be approved before you can login.'
            ]);
        }

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        redirect()->route('app.home')->with('logout_success', 'Sucessfully Logged Out');
    }
}
