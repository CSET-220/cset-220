<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Family;
use App\Models\Log;
use App\Models\Patient;
use App\Models\Role;
use App\Models\Roster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        $request->validate(
            // Validation Requirements
            [
                // Im pretty sure rfc,dns, the email has to be something@something.something and unique checks tableName,columnName for the same values, idk if case sensitive or not
                // you can add multiple verification with | separator or put them in arrays 
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => [
                    'required', // cant be empty
                    'min:8', // minimum 8 characters
                    'regex:/[a-z]/', // at least 1 lowercase
                    'regex:/[A-Z]/', // at least 1 uppercase
                    'regex:/[0-9]/', // at least 1 number
                    'regex:/[@$!%*#?&]/'// 1 special character
                ],
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'date_of_birth' => [
                    'required',
                    'date',
                    'before:'.now()->subYears(18)->format('Y-m-d'),
                    // Custom rule uses Illuminate\Validation\Rule facade and can add custom validation with,Rule::when(this happens, use this validation on this field)
                    Rule::when(request('user_type') === 'patient', ['before_or_equal:' . now()->subYears(40)->format('Y-m-d')]),//beforeOrEqual(now()->subYears(40)->format('Y-m-d'))->when(function ($input) {
                        //return $input['user_type'] === 'patient';
                    //}),
                ],
                'user_type' => 'required',
                'family_code' => 'required_if:user_type,patient', // cant be empty if:thisField,hasValue
                'emergency_contact' => 'required_if:user_type,patient',
                'emergency_relation' => 'required_if:user_type,patient',
            ],
            // Custom validation error messages
            // reference inputFieldName.validationName => 'Whatever message you want to say if that specific validation fails'
            [
                'email.required' => 'Please enter your Email',
                'email.email' => 'Please enter a valid Email',
                'email.unique' => 'This Email is already connected to an Account',
                'password.regex' => 'Password must contain AT LEAST 1 Number, 1 Uppercase Letter, 1 Lowercase Letter, and 1 Special Character',
                'password.required' => 'Please enter your Password',
                'first_name.required' => 'Please enter your First Name',
                'last_name.required' => 'Please enter your Last Name',
                'phone.required' => 'Please enter your Phone Number',
                'date_of_birth.required' => 'Please enter your Date of Birth',
                'date_of_birth.before' => 'Must be 18 or older',
                'date_of_birth.before_or_equal' => 'You must be at least 40 years old to register as a patient.',
                'user_type.required' => 'Please enter Patient or Family Member',
                'family_code.required_if' => 'If you are a patient please enter a Family Code',
                'emergency_contact.required_if' => 'If you are a patient please enter an Emergency Contact',
                'emergency_relation.required_if' => 'If you  are a patient please enter your contact\'s relation to you',
            ]
        );
        // have to get each field individually because request->all() will use all fields including family_code and relation in User::create()
        $email = $request->email;
        $password = $request->password;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $dob = $request->date_of_birth;
        $role_title = $request->user_type;
        $role = Role::where('role_title',$role_title)->first(); // gets row from roles where role_title to insert into users
        // dd($role->id);
        User::create(['role_id' => $role->id,'first_name' => $first_name,'last_name' => $last_name,'email' => $email,'phone' => $phone,'password' => $password,'dob' => $dob]);
        if($role_title === 'patient' || $role_title === 'family'){
            if($role_title === 'patient'){
                $new_patient = User::where('email',$email)->first();
                $user_id = $new_patient->id;
                $family_code = $request->family_code;
                $emergency_contact = $request->emergency_contact;
                $emergency_relation = $request->emergency_relation;
                Patient::create(['user_id' => $user_id,'family_code' => $family_code, 'emergency_contact' => $emergency_contact, 'contact_relation' => $emergency_relation]);
            }
            return redirect()->route('app.home')->with('register_success', 'Account Created! Please wait for approval.');
        }
        // when role is one of the employees, supervisor, doctor, and caregiver act like its an appplication
        else{
            return redirect()->route('app.home')->with('register_success', 'Application Received! Please wait for approval.');
        }
    }

    public function employeeRegister(){
        return view('home.employeeRegister');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::check()){
            date_default_timezone_set('America/New_York');
            $user_info = User::with(['patient.logs' => function($query){
                $query->where('date', '<=', now())->orderBy('date','desc')->take(3)->with('caregiver');
            }, 
            'employees', 'patient.appointments' => function ($query) {
                $query->where('date', '>=', now())
                ->orderBy('date','asc')
                ->with(['doctor','morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions',]);
            }
            
            , 'patient.families','families.patient.user','families.patient.logs' => function($query){
                $query->where('date', date('Y-m-d'))->first();
            },
            'families.patient.appointments' => function($query){
                $query->where('date', '<', date('Y-m-d'))->orderBy('date', 'desc')->with(['morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions',])->first();
            },'logs', 'doctorRosters', 'supervisorRosters', 'caregiver1Rosters', 'caregiver2Rosters', 'caregiver3Rosters', 'caregiver4Rosters'])->where('id',Auth::id())->first();
            // Get everyone on the roster today
            $roster = Roster::where('date', date('Y-m-d'))->first();

            if(Auth::user()->getAccess(['patient'])){
                $user_info->lastApt = Appointment::getLastAppointment($user_info->patient->id)->with(['morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions'])->get();
            }
            // dd($user_info->lastApt);
            // Get all appointments for admin and supervisor
            $allApts = collect();
            if(Auth::user()->getAccess(['admin', 'supervisor'])){
                $allApts = Appointment::with(['patient.user', 'doctor'])->where('date', date('Y-m-d'))->select(['id','date', 'patient_id', 'doctor_id'])->get();
                // dd($allApts);
            }
            // Get all appointments for a specific doctor
            $drApt = collect();
            if(Auth::user()->getAccess(['doctor'])){
                $drApt = Appointment::with(['patient', 'doctor', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions', ])
                ->where('date', date('Y-m-d'))
                ->where('doctor_id', Auth::id())
                ->get()
                ->map(function ($appointment) { // Adds patients lastAppointment with relationships to the drApt collection
                    $lastAppointment = Appointment::where('patient_id', $appointment->patient_id)
                        ->where('comments', '!=', null)
                        ->orderBy('date', 'desc')
                        ->first();
                    if ($lastAppointment) {
                        $lastAppointment->load(['patient', 'doctor', 'morningPrescriptions', 'afternoonPrescriptions', 'nightPrescriptions']);
                    }
                    $appointment->lastAppointment = $lastAppointment;
                    return $appointment;
                });
            }
            $caregiverPatients = collect();
            if(Auth::user()->getAccess(['caregiver'])){
                $caregiverPatients = Log::with(['patient.user', 'caregiver'])->where('caregiver_id', Auth::id())->where('date', date('Y-m-d'))->get();
            }
            $userCounts = [
                'allUsers' => User::count(),
                'patient' => User::where('role_id', Role::where('role_title', 'patient')->first()->id)->count(),
                'family' => User::where('role_id', Role::where('role_title', 'family')->first()->id)->count(),
                'admin' => User::where('role_id', Role::where('role_title', 'admin')->first()->id)->count(),
                'supervisor' => User::where('role_id', Role::where('role_title', 'supervisor')->first()->id)->count(),
                'doctor' => User::where('role_id', Role::where('role_title', 'doctor')->first()->id)->count(),
                'caregiver' => User::where('role_id', Role::where('role_title', 'caregiver')->first()->id)->count(),
            ];
            // dd($caregiverPatients);
            return view('profile.profile', ['user_info' => $user_info, 'roster' => $roster, 'allApts' => $allApts, 'drApt' => $drApt, 'caregiverPatients' => $caregiverPatients,'userCounts' => $userCounts]);
        }
        else{
            return redirect()->route('app.home')->with('access_error', 'Please Login to view profile.');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    // Edit User Info
    public function update(Request $request, string $id)
    {
        if(Auth::check()){
            $request->validate(
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone' => 'required',
                    'email' => [
                            'required',
                            'email:rfc,dns',
                            Rule::unique('users')->ignore(Auth::user()),
                        ],
                        'dob' => [
                                'required',
                                'date',
                                'before:'.now()->subYears(18)->format('Y-m-d'),
                                // Custom rule uses Illuminate\Validation\Rule facade and can add custom validation with,Rule::when(this happens, use this validation on this field)
                                Rule::when(Auth::user()->getAccess(['patient']), ['before_or_equal:' . now()->subYears(40)->format('Y-m-d')]),
                        
                        ],
                        
                        'contact_relation' => [
                            Rule::when(Auth::user()->getAccess(['patient']), 'required')
                        ],
                        'emergency_contact' => [
                            Rule::when(Auth::user()->getAccess(['patient']), ['required'])
                        ],
                        // 'family_code' => [
                        //     Rule::when(Auth::user()->getAccess(['patient']), ['required'])
                        // ],
                ],
                [
                    'first_name.required' => 'Please enter your First Name',
                    'last_name.required' => 'Please enter your Last Name',
                    'email.required' => 'Please enter your Email',
                    'email.email' => 'Please enter a valid Email',
                    'email.unique' => 'This Email is already connected to an Account',
                    'phone.required' => 'Please enter your Phone Number',
                    'dob.required' => 'Please enter your Date of Birth',
                    'dob.before' => 'Must be 18 or older',
                    'dob.before_or_equal' => 'You must be at least 40 years old to be a patient.',
                    'emergency_contact.required' => 'Please enter an Emergency Contact',
                    'contact_relation.required' => 'Please enter your contact\'s relation to you',
                    'family_code.required' => 'Please enter your Family Code'

                ]
            );
            $email = $request->email;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $phone = $request->phone;
            $dob = $request->dob;
            User::where('id', Auth::id())->update(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'dob' => $dob]);
            if(Auth::user()->getAccess(['patient'])){
                $contact_relation = $request->contact_relation;
                $emergency_contact = $request->emergency_contact;
                $family_code = $request->family_code;
                $prevFamCode = Patient::where('user_id', Auth::id())->first();
                if($family_code === ""){
                    $hashedCode = $prevFamCode->family_code;
                }
                else{
                    $hashedCode = Hash::make($family_code);
                }
                Patient::where('user_id', Auth::id())->update(['contact_relation' => $contact_relation, 'emergency_contact' => $emergency_contact, 'family_code' => $hashedCode]);
            }

            return redirect()->route('users.show',['user' => Auth::user()])->with('edit_profile_success', 'Profile Updated Successfully');

        }
        else{
            return redirect()->route('app.home')->with('access_error', 'Please Login to view profile.');
        }
    }


    public function payment(Request $request, $id){
        $request->validate([
                'payment' => 'required|numeric',
            ],
            [
                'payment.required' => 'Please enter a deposit amount',
            ]
        );

        $amount = $request->payment;
        Patient::where('user_id', $id)->update(['last_paid_date' => date('Y-m-d')]);
        Patient::where('user_id', $id)->decrement('balance', $amount);
        // Patient::where('user_id', $id)->update(['balance' => number_format($balance->balance - $amount,2,"."), 'last_paid_date' => date('Y-m-d')]);
        return redirect()->route('users.show',['user' => Auth::user()])->with('payment_success', 'Payment Received');
    }


    // Gets patient from fam code
    public function familyCodeSearch(Request $request, $id){
        // $famCode = $request->fam_code_search;

        // $familyMembers = Patient::with(['user', 'logs' => function($query){
        //     $query->where('date', '=', date('Y-m-d'))->orderBy('date','desc')->with('caregiver')->first();
        // }])->get();
        // $allFam = [];
        // foreach ($familyMembers as $familyMember) {
        //     if (Hash::check($famCode, $familyMember->family_code)) {
        //         array_push($allFam,$familyMember);
        //     }
        // }
        // session(['familyMembers' => $allFam]);
        // return redirect()->route('users.show');
    }
        if(Auth::check()){
            $request->validate(
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone' => 'required',
                    'email' => [
                            'required',
                            'email:rfc,dns',
                            Rule::unique('users')->ignore(Auth::user()),
                        ],
                        'dob' => [
                                'required',
                                'date',
                                'before:'.now()->subYears(18)->format('Y-m-d'),
                                // Custom rule uses Illuminate\Validation\Rule facade and can add custom validation with,Rule::when(this happens, use this validation on this field)
                                Rule::when(Auth::user()->getAccess(['patient']), ['before_or_equal:' . now()->subYears(40)->format('Y-m-d')]),
                        
                        ],
                        
                        'contact_relation' => [
                            Rule::when(Auth::user()->getAccess(['patient']), 'required')
                        ],
                        'emergency_contact' => [
                            Rule::when(Auth::user()->getAccess(['patient']), ['required'])
                        ],
                        // 'family_code' => [
                        //     Rule::when(Auth::user()->getAccess(['patient']), ['required'])
                        // ],
                ],
                [
                    'first_name.required' => 'Please enter your First Name',
                    'last_name.required' => 'Please enter your Last Name',
                    'email.required' => 'Please enter your Email',
                    'email.email' => 'Please enter a valid Email',
                    'email.unique' => 'This Email is already connected to an Account',
                    'phone.required' => 'Please enter your Phone Number',
                    'dob.required' => 'Please enter your Date of Birth',
                    'dob.before' => 'Must be 18 or older',
                    'dob.before_or_equal' => 'You must be at least 40 years old to be a patient.',
                    'emergency_contact.required' => 'Please enter an Emergency Contact',
                    'contact_relation.required' => 'Please enter your contact\'s relation to you',
                    'family_code.required' => 'Please enter your Family Code'

                ]
            );
            $email = $request->email;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $phone = $request->phone;
            $dob = $request->dob;
            User::where('id', Auth::id())->update(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'dob' => $dob]);
            if(Auth::user()->getAccess(['patient'])){
                $contact_relation = $request->contact_relation;
                $emergency_contact = $request->emergency_contact;
                $family_code = $request->family_code;
                $prevFamCode = Patient::where('user_id', Auth::id())->first();
                if($family_code === ""){
                    $hashedCode = $prevFamCode->family_code;
                }
                else{
                    $hashedCode = Hash::make($family_code);
                }
                Patient::where('user_id', Auth::id())->update(['contact_relation' => $contact_relation, 'emergency_contact' => $emergency_contact, 'family_code' => $hashedCode]);
            }

            return redirect()->route('users.show',['user' => Auth::user()])->with('edit_profile_success', 'Profile Updated Successfully');

        }
        else{
            return redirect()->route('app.home')->with('access_error', 'Please Login to view profile.');
        }
    }


    public function payment(Request $request, $id){
        $request->validate([
                'payment' => 'required|numeric',
            ],
            [
                'payment.required' => 'Please enter a deposit amount',
            ]
        );

        $amount = $request->payment;
        Patient::where('user_id', $id)->update(['last_paid_date' => date('Y-m-d')]);
        Patient::where('user_id', $id)->decrement('balance', $amount);
        // Patient::where('user_id', $id)->update(['balance' => number_format($balance->balance - $amount,2,"."), 'last_paid_date' => date('Y-m-d')]);
        return redirect()->route('users.show',['user' => Auth::user()])->with('payment_success', 'Payment Received');
    }


    // Gets patient from fam code
    public function familyCodeSearch(Request $request, $id){
        // $famCode = $request->fam_code_search;

        // $familyMembers = Patient::with(['user', 'logs' => function($query){
        //     $query->where('date', '=', date('Y-m-d'))->orderBy('date','desc')->with('caregiver')->first();
        // }])->get();
        // $allFam = [];
        // foreach ($familyMembers as $familyMember) {
        //     if (Hash::check($famCode, $familyMember->family_code)) {
        //         array_push($allFam,$familyMember);
        //     }
        // }
        // session(['familyMembers' => $allFam]);
        // return redirect()->route('users.show');
    }
    public function edit($id){

    }


    public function editProfilePic(Request $request){
        $request->validate(
            [
                'profile_pic' => 'required'
            ]
        );
        $pic = $request->profile_pic;
        $fileName = time(). "." . $pic->getClientOriginalExtension();
        // dd($fileName);
        $pic->move(public_path('/images/profile_pics'),$fileName);
        $user = Auth::user();
        $user->profile_pic = 'images/profile_pics/'.$fileName;
        $user->save();
        return redirect()->route('users.show', ['user' => Auth::user()])->with('edit_profile_success', "Successfully Added a Profile Picture");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->getAccess(['patient'])){
            // dd($id);
            Appointment::where('patient_id', $id)->delete();
            Log::where('patient_id',$id)->delete();
            Patient::where('user_id', $id)->delete();
        }
        elseif (Auth::user()->getAccess(['doctor'])) {
            Roster::where('doctor_id',$id)->delete();
            Appointment::where('doctor_id', $id)->delete();
            Employee::where('user_id', $id)->delete();

        }
        elseif(Auth::user()->getAccess(['supervisor'])){
            Roster::where('supervisor_id',$id)->delete();
            Employee::where('user_id', $id)->delete();
        }
        elseif(Auth::user()->getAccess(['caregiver'])){
            Roster::where('caregiver1_id', $id)->orWhere('caregiver2_id', $id)->orWhere('caregiver3_id', $id)->orWhere('caregiver4_id', $id)->delete();
            Log::where('caregiver_id', $id)->delete();
            Employee::where('user_id', $id)->delete();
        }

        User::destroy($id);
        return redirect()->route('app.home')->with('deletion_success', 'Account Successfully Deleted');
    }
}
