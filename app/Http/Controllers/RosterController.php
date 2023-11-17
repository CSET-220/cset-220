<?php

namespace App\Http\Controllers;

use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        // TODO add user once auth is implemented
        $rosters = Roster::where('date', '>=', date('Y-m-d'))->paginate(10);
        return view('rosters.index', compact('rosters'));
    }

    public function dateSearch(Request $request)
    {
        // TODO add user once auth is implemented
        $date = date('Y-m-d', strtotime($request->date));
        $rosters = Roster::where('date', '=', $date)->paginate(10);
        return view('rosters.index', compact('rosters'));
    }
    

    public function create()
    {
        return view('rosters.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
