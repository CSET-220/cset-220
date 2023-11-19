<?php

namespace App\Http\Controllers;

use App\Models\Roster;
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
        // TODO add user once auth is implemented
        $rosters = Roster::where('date', '>=', date('Y-m-d'))->orderBy('date', 'asc')->paginate(10);
        return view('rosters.index', compact('rosters'));
    }

    public function dateSearch(Request $request)
    {
        // TODO add user once auth is implemented
        // TODO possibly add ajax to not go to new page
        // TODO add validation
        $date = date('Y-m-d', strtotime($request->date));
        $rosters = Roster::where('date', '=', $date)->orderBy('date', 'asc')->paginate(10);
        return view('rosters.index', compact('rosters'));
    }
    

    public function create()
    {   
        // TODO add user once auth is implemented
        // TODO need to protect route can only be accessed by admin/supervisor
        $doctors = User::where('role_id', 3)->get();
        $supervisors = User::where('role_id', 2)->get();
        $caregivers = User::where('role_id', 4)->get();
        return view('rosters.create', compact('doctors', 'supervisors', 'caregivers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO add user once auth is implemented
        // TODO need to protect route can only be accessed by admin/supervisor
        // TODO validate maybe before adding to db
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->date));
        Roster::create([
            'doctor_id' => $request->doctor_id,
            'supervisor_id' => $request->supervisor_id,
            'caregiver1_id' => $request->caregiver1_id,
            'caregiver2_id' => $request->caregiver2_id,
            'caregiver3_id' => $request->caregiver3_id,
            'caregiver4_id' => $request->caregiver4_id,
            'date' => $date,
        ]);

        return redirect()->route('rosters.index');
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
