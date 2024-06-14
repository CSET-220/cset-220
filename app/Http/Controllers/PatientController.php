<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        //
    }

    public function create(){
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function logs(string $id) {
        if(Auth::check() and auth()->user()->patient->id == $id) {
            $patient = Patient::with(['logs', 'appointments.doctor'])->findOrFail($id);
            return view('patients.logs', compact('patient'));
        }
        else {
            return abort(401);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function edit($id){
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
