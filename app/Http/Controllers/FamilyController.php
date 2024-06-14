<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Family;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FamilyController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        if(Auth::check() and Auth::id() == $id) {
            $family = Family::getAllFamily($id)->get();
            $user = User::with(['families'])->find($id);

            return view('family.show', compact('user'));
        }
        else {
            return abort(401);
        }
    }

    public function confirmFamilyMember(Request $request)
    {
        $patient_id = $request->input('patient_id');
        $family_code = $request->input('family_code');
        
        $patient = Patient::find($patient_id);

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient ID not found'
            ]);
        }
        elseif ($patient->family_code != $family_code) {
            return response()->json([
                'status' => 'error',
                'message' => 'Family code does not match'
            ]);
        }
        elseif (Family::familySearch($patient_id, Auth::id())->first()) {
            return response()->json([
                'status' => 'error',
                'message' => "You're already connected with this patient"
            ]);
        }
        else {
            Family::create([
                'family_id' => Auth::id(),
                'patient_id' => $request->patient_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Family member added successfully',
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function logs(string $patient_id)
    {
        $confirm_family = Family::familySearch($patient_id, Auth::id())->first();
        if (Auth::check() and $confirm_family) {
            $user = Auth::user();
            $patient = Patient::with(['logs', 'appointments.doctor'])->find($patient_id);
            return view('family.logs', compact('patient'));
        }
        else {
            return abort(401);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
