<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                $group = rand(1,4);
                Patient::create(['user_id' => $user_id,'group' => $group,'family_code' => $family_code, 'emergency_contact' => $emergency_contact, 'contact_relation' => $emergency_relation]);
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
