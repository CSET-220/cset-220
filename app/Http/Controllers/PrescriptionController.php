<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::check() && Auth::user()->getAccess(['admin','supervisor','doctor'])){
            // chris getting ajax request for dr apt
            if ($request->ajax()) {
                $prescriptions = Prescription::all();
                return response()->json($prescriptions);
            }
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }

    public function getDosage($prescription_name){
        $dosage = Prescription::where('medication_name', $prescription_name)->get();
        return response()->json($dosage);
    }

    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::check() && Auth::user()->getAccess(['doctor'])){
            $request->validate(
                [
                    'medication_name' => 'required',
                    'medication_dosage' => 'required'
                ]
            );
            $name = $request->medication_name;
            $dose = $request->medication_dosage;
    
            $unique = Prescription::where('medication_name', $name)->where('medication_dosage', $dose)->first();
            if($unique){
                return redirect()->route('users.show', ['user' => Auth::user()])->withErrors([
                    'medication_name' => 'That Prescription already exists'
                ]);
            }

            Prescription::create(['medication_name' => $name, 'medication_dosage' => $dose]);
            return redirect()->route('users.show', ['user' =>Auth::user()])->with('edit_profile_success', 'Successfully Added a new Prescription');
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'You do not have permission to access this page');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function edit($id){

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
