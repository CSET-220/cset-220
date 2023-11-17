<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        $users = User::where('is_approved', 0)->get();
        return view('admin.reg_approval', compact('users'));
    }

    public function approve($id){
        $user = User::find($id);
        $user->is_approved = 1;
        $user->save();
        return redirect()->back();
    }
}
