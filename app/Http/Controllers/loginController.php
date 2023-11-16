<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function home(){
        return view('index');
    }

    public function login(Request $request){
        // User can login using family code or email
        //
        // $loginType = $request->loginType;
        // $emailOrFamCode = filter_var($loginType,FILTER_VALIDATE_EMAIL) ? 'email' : 'family_code';
        // dd($emailOrFamCode);
        $credentials = $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Please enter valid Email',
                'password.required' => 'Please enter a password'
            ]
    
        );
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            dd($user->getAccess(['admin']));
            if($user->getAccess(['admin'])){
                dd('ADMIN LOGGED IN');
            }
        }
        else{
            return redirect()->back()->withErrors([
                'email' => 'Invalid Credentials'
            ]);
        }

    }
}
