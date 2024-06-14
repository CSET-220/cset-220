<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['supervisor'])) {
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['doctor'])) {
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['caregiver'])) {
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['family'])) {
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
            elseif ($user->getAccess(['patient'])) {
                return redirect()->route('users.show',['user' => Auth::user()])->with('login_success','Login Successful');
            }
        }
        else{
            $user = User::where('email', $request->login_email)->first();
            if ($user && $user->approved === false) {
                return redirect()->back()->withErrors(['login_email' => 'You must be approved before you can login.']);
            }
            else{
                return redirect()->back()->withErrors(['login_email' => 'The password you entered is incorrect.']);
            }
        }

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect()->route('app.home')->with('logout_success', 'Sucessfully Logged Out');
    }
}
