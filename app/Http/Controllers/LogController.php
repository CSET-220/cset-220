<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(){

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

    public function updateLog(Request $request) 
    {
        $validated = $request->validate([
            'patient_id' => 'required|integer',
            'log_type' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);
        $log = Log::where('patient_id', $validated['patient_id'])
            ->where('date', $validated['date'])
            ->first();
        if(!$log) {
            return response()->json(['error' => 'Log not found'], 404);
        }
        $log->{$validated['log_type']} = $validated['status'];
        $log->save();
        return response()->json(['success' => true]);
    }
}
