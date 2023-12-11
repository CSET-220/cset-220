<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Roster;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        if(Auth::check()) {
            // $rosters = Roster::where('date', '>=', date('Y-m-d'))->orderBy('date', 'asc')->paginate(10);
            $rosters = Roster::all();
            return view('rosters.index', compact('rosters'));
        } else {
            // TODO fix this error message not showing up tried to set it up in the view but it didn't work
            return redirect()->route('app.home')->withErrors([
                'not_auth' => 'You must be logged in to view this page.'
            ]);
        }
    }

    public function create()
    {   
        if(Auth::check()) {
            $user = Auth::user();
            if (auth()->user()->getAccess(['admin', 'supervisor'])) {
                $doctors = User::where('role_id', 3)->get();
                $supervisors = User::where('role_id', 2)->get();
                $caregivers = User::where('role_id', 4)->get();
                return view('rosters.create', compact('doctors', 'supervisors', 'caregivers'));
            } else {
                // TODO fix this error message not showing up tried to set it up in the view but it didn't work
                return redirect()->route('app.home')->withErrors([
                    'not_auth' => 'You do not have access to this page.'
                ]);
            }
        } else {
            // TODO fix this error message not showing up tried to set it up in the view but it didn't work
            return redirect()->route('app.home')->withErrors([
                'not_auth' => 'You need to login.'
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the request
        $request->validate([
            'doctor_id' => 'required',
            'supervisor_id' => 'required',
            'caregiver1_id' => 'required',
            'caregiver2_id' => 'required',
            'caregiver3_id' => 'required',
            'caregiver4_id' => 'required',
            'date' => 'required',
        ]);

        $date = date('Y-m-d', strtotime($request->date));
        if(Roster::where('date', $date)->exists()) {
            return redirect()->route('rosters.create')->withErrors([
                'date_error' => 'There is already a roster for that date.'
            ]);
        } else {
            // create the roster
            $roster = Roster::create([
                'doctor_id' => $request->doctor_id,
                'supervisor_id' => $request->supervisor_id,
                'caregiver1_id' => $request->caregiver1_id,
                'caregiver2_id' => $request->caregiver2_id,
                'caregiver3_id' => $request->caregiver3_id,
                'caregiver4_id' => $request->caregiver4_id,
                'date' => $date,
            ]);
            
            for($group = 1; $group <= 4; $group++) {
                $caregiverIDField = 'caregiver' . $group . '_id';
                $caregiverID = $roster->$caregiverIDField;

                $patientsIDs = Patient::where('group', $group)->pluck('id');

                foreach($patientsIDs as $patientID) {
                    Log::create([
                        'caregiver_id' => $caregiverID,
                        'patient_id' => $patientID,
                        'date' => $date,
                    ]);
                }
            }
            return redirect()->route('rosters.create')->with('success', 'Roster created successfully.');
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
