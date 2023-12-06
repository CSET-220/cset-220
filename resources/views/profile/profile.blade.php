@extends('layouts.app')


@section('linkStyles')
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <script src="https://unpkg.com/flowbite-datepicker@1.2.2/dist/js/datepicker-full.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
@endsection

@section('title')
    Wrinkly Ranch - Welcome {{ ucwords(Auth::user()->full_name) }}
@endsection

@section('pageHeader')
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-6 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome {{ Auth::user()->full_name }}</h1>
            <p class="text-lg">Profile</p>

            @if (session('edit_profile_success'))
                <p class="text-green-500">{{ session('edit_profile_success') }}</p>
            @endif
            
            @if (session('bill_success'))
                <p class="text-green-500">{{ session('bill_success') }}</p>
            @endif
        </div>
    </div>
    {{--  --}}
@endsection

@section('mainContent')
{{-- STAFF INFORMATION FOR POPOVERS --}}
@php
    $staff = [$roster->supervisor, $roster->doctor, $roster->caregiver1,$roster->caregiver2,$roster->caregiver3,$roster->caregiver4]
@endphp
{{-- INCLUDE THE PAYMENT MODAL IF PATIENT --}}
@if (Auth::user()->getAccess(['patient']))
    @include('components.profile.paymentModal')
@endif

{{-- <div class="mx-auto w-full"> --}}
    <div class="flex justify-around flex-col sm:flex-wrap sm:flex-row p-8 pt-8 sm:pb-20 sm:w-full flex-grow">
        {{-- Left side --}}
        <div class="flex flex-col mr-0 mb-4 w-full md:w-1/3 md:mr-6 flex-grow">

            {{-- Top Left --}}
            <div class="bg-gray-800 p-4 rounded-lg mb-4 shadow-gray-600 shadow-md w-full text-right flex-grow">
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-400 hover:bg-gray-700 focus:ring-4 focus:outline-none ring-gray-200 focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden text-base list-none divide-y divide-gray-100 rounded-lg shadow w-44 bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">
                        <li>
                            <a id="edit_profile_btn" class="text-left cursor-pointer block px-4 py-2 text-sm hover:bg-gray-600 text-gray-200 hover:text-white">Edit Information</a>
                        </li>

                        <li>
                            <a id="edit_prof_pic" data-modal-target="edit-pic-modal"data-modal-toggle="edit-pic-modal" class="text-left cursor-pointer block px-4 py-2 text-sm hover:bg-gray-600 text-gray-200 hover:text-white">Edit Profile Picture</a>
                        </li>
    
                        {{-- LINK TO PAYMENT MODAL --}}
                        @if (Auth::user()->getAccess(['patient']))
                            <li>
                                <a data-modal-target="payment-modal" data-modal-toggle="payment-modal" class="cursor-pointer text-left block px-4 py-2 text-sm  hover:bg-gray-600 text-gray-200 hover:text-white">Make a Payment</a>
                            </li>
                        
                        @elseif (Auth::user()->getAccess(['admin']))
                            <li>
                                <a href="{{ route('bill.patients', ['user' => Auth::user()]) }}" class="w-full text-left cursor-pointer block px-4 py-2 text-sm hover:bg-gray-600 text-gray-200 hover:text-white">Bill Patients</a>
                            </li>
                        @endif
                        <li>
                            <a id="show-delete-modal" data-modal-target="delete-user-modal"data-modal-toggle="delete-user-modal" class="text-left cursor-pointer block px-4 py-2 text-sm hover:bg-gray-600 text-red-500 hover:text-white">Delete Account</a>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col flex-grow items-center pb-4 my-auto py-5">
                    @if (Auth::user()->profile_pic)
                        <img class="w-24 lg:w-48 h-24 lg:h-48 mb-3 rounded-full shadow-lg object-cover" src="{{ asset(Auth::user()->profile_pic) }}" alt=""/>
                    @else
                        <div class="relative inline-flex items-center justify-center mb-3 rounded-full shadow-lg object-cover w-24 h-24 overflow-hidden bg-gray-100 dark:bg-gray-600">
                            @php
                                $words = explode(" ",$user_info->full_name);
                                $userInitials = '';
                                $userInitials .= strtoupper($words[0][0]) . strtoupper($words[1][0]);

                            @endphp
                            <span class="font-bold text-5xl text-gray-600 dark:text-gray-300 ">{{ $userInitials }}</span>
                        </div>
                    @endif
                    <h5 class="mb-1 text-xl font-medium text-white">{{ ucwords($user_info->full_name) }}</h5>
                    <span class="text-sm text-gray-500">{{ ucwords($user_info->role->role_title) }}</span>
                    {{-- ADMISSION DATE/ BALANCE for Patient --}}
                    @if (Auth::user()->getAccess(['patient']))
                        <p class="text-sm text-gray-500">Admitted: {{ date('F d, Y',strToTime($user_info->patient->admission_date)) }}</p>
                        <p class="text-sm text-blue-500 flex flex-col items-center">Balance: ${{ number_format($user_info->patient->balance,2,".",",") }} <span> Paid On: {{ date('F d, Y',strToTime($user_info->patient->last_paid_date)) }}</span></p>
                        @error('payment')
                            <p class="text-sm text-red-500">{{ $errors->first('payment') }}</p>
                        @enderror
                        @if (session('payment_success'))
                            <p class="text-sm text-green-500">{{ session('payment_success') }}</p>
                        @endif
                    @endif
                </div>
            </div>




            {{-- Bottom Left --}}
            <div class="bg-gray-200 p-4 lg:p-4 rounded-lg shadow-gray-600 shadow-md w-full flex-grow">
                <div class="mt-1">
                    <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                        <span clas="text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1V362c27.6 7.1 48 32.2 48 62v40c0 8.8-7.2 16-16 16H336c-8.8 0-16-7.2-16-16s7.2-16 16-16V424c0-17.7-14.3-32-32-32s-32 14.3-32 32v24c8.8 0 16 7.2 16 16s-7.2 16-16 16H256c-8.8 0-16-7.2-16-16V424c0-29.8 20.4-54.9 48-62V304.9c-6-.6-12.1-.9-18.3-.9H178.3c-6.2 0-12.3 .3-18.3 .9v65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7V311.2zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                        </span>
                        <span class="tracking-wide">Today's Medical Staff</span>
                    </div>
                    <div class="flex justify-evenly w-full mt-4">
                        @foreach ($staff as $employee)
                            @php
                                $names = explode(' ', $employee->full_name);
                                $initials = '';
                                foreach ($names as $name) {
                                    $initials .= strtoupper(substr($name, 0, 1));
                                }
                            @endphp
                            @if($employee->profile_pic)
                                <img data-popover-target="popover-doctor-{{ $initials }}" src="{{ asset($employee->profile_pic) }}" alt="" srcset="" class="w-8 h-8 rounded-full cursor-pointer ">
                            @else
                                <div data-popover-target="popover-doctor-{{ $initials }}" class=" cursor-pointer relative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600">
                                    <span class="font-medium text-gray-300">{{ $initials }}</span>
                                </div>
                            @endif
                            <div data-popover id="popover-doctor-{{ $initials }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                <div class="p-3">
                                    <div class="flex items-center justify-between mb-2">
                                        @if($employee->profile_pic)
                                            <img src="{{ asset($employee->profile_pic) }}" alt="" srcset="" class="w-8 h-8 rounded-full cursor-pointer ">
                                        @else
                                            <div class=" cursor-pointer relative inline-flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-blue-600">
                                                <span class="font-medium text-gray-300">{{ $initials }}</span>
                                            </div>
                                        @endif
                                        <p>{{ ucwords($employee->role->role_title) }}</p>
                                        <div>
                                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Call</button>
                                        </div>
                                    </div>
                                    <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                        <a >{{ ucwords($employee->full_name) }}</a>
                                    </p>
                                    <p class="mb-3 text-sm font-normal">
                                        <a class="cursor-pointer hover:underline">{{ $employee->email }}</a>
                                    </p>
                                    <p class="mb-4 text-sm">Contact: <a class="text-blue-600 dark:text-blue-500 hover:underline">{{ $employee->phone }}</a>.</p>
                                    
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        @endforeach
                    </div>
                </div>


                @if (Auth::user()->getAccess(['patient']))
                    @include('components.profile.patientRelated')
                @endif
            </div>


        </div>

        {{-- Right Side --}}
        <div class="flex flex-col justify-between ml-0 mb-4 w-full md:w-3/5 md:ml-6 flex-grow">


            {{-- Top Right --}}
            <div class="bg-gray-200 p-4 rounded-lg shadow-gray-600 mb-4 shadow-md flex-grow">

                <div class="p-2 rounded-sm">
                    <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                        <span clas="text-green-500">
                            <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <span class="tracking-wide">About</span>
                    </div>
                </div>

                <div class="text-gray-700">
                    <div id="user_info" class="flex flex-wrap text-sm ">

                        <div class="relative flex  justify-start w-1/2 my-2">
                            <div class="px-4 py-2 font-bold">First Name</div>
                            <div>
                                <div class="edit_user_info px-4 py-2">{{ ucwords($user_info->first_name) }}</div>
                                @error('first_name')
                                    <p class="text-sm text-red-500">{{ $errors->first('first_name') }}</p>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="relative flex justify-start w-1/2 my-2">
                            <div class="px-4 py-2 font-bold">Last Name</div>
                            <div>
                                <div class="edit_user_info px-4 py-2">{{ ucwords($user_info->last_name) }}</div>
                                @error('last_name')
                                    <p class="text-sm text-red-500">{{ $errors->first('last_name') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative flex justify-start w-1/2 my-2">
                            <div class="px-4 py-2 font-bold">Email</div>
                            <div>
                                <div class="edit_user_info px-4 pl-0 py-2 cursor-pointer text-blue-500 hover:underline hover:underline-offset-2">{{ ucwords($user_info->email) }}</div>
                                @error('email')
                                    <p class="text-sm text-red-500">{{ $errors->first('email') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative flex justify-start w-1/2 my-2">
                            <div class="py-2 px-4 font-bold">Phone Number</div>
                            <div>
                                <div class="edit_user_info px-4 py-2">{{ ucwords($user_info->phone) }}</div>
                                @error('phone')
                                    <p class="text-sm text-red-500">{{ $errors->first('phone') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative flex justify-start w-1/2 my-2">
                            <div class="px-4 py-2 font-bold">Birthday</div>
                            <div>
                                <div class="edit_user_info px-4 py-2">{{ date('F d, Y', strToTime($user_info->dob)) }}</div>
                                @error('dob')
                                    <p class="text-sm text-red-500">{{ $errors->first('dob') }}</p>
                                @enderror
                            </div>
                        </div>

                        @if (Auth::user()->getAccess(['patient']))
                            <div class="flex justify-start w-1/2 my-2">
                                <div>
                                    <div class="edit_user_info px-4 py-2 font-bold">{{ $user_info->patient->contact_relation == 'extended' ? 'Extended Family' : ucwords($user_info->patient->contact_relation) }} </div>
                                    @error('contact_relation')
                                        <p class="text-sm text-red-500">{{ $errors->first('contact_relation') }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <div class="edit_user_info px-4 py-2">{{ $user_info->patient->emergency_contact }}</div>
                                    @error('emergency_contact')
                                        <p class="text-sm text-red-500">{{ $errors->first('emergency_contact') }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- EDIT USER INFO FORM --}}
                    <form action="{{ route('users.update', ['user' => Auth::id()]) }}" method="post" id="edit_user_form" class="hidden ">
                        @csrf
                        <div class="flex flex-wrap text-sm ">
                            @method("PUT")

                            <div class="relative z-0 flex justify-start w-1/2 my-2">
                                <input value="{{ $user_info->first_name }}" type="text" id="" name="first_name" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="first_name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">First Name</label>
                            </div>
                            
                            <div class="relative z-0 flex justify-start w-1/2 my-2">
                                <input value="{{ $user_info->last_name }}" type="text" id="" name="last_name" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="last_name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Last Name</label>
                            </div>
    
                            <div class="relative z-0 flex justify-start w-1/2 my-2">
                                <input value="{{ $user_info->email }}" type="email" id="" name="email" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Email</label>
                            </div>
    
                            <div class="relative z-0 flex justify-start w-1/2 my-2">
                                <input value="{{ $user_info->phone }}" type="text" id="user_phone" name="phone" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="phone" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Phone</label>
                            </div>
                            
                            <div class="relative z-0 flex justify-start w-1/2 my-2">
                                <input type="text" id="datepicker" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" value="{{ $user_info->dob }}"  name="dob" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="dob" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Birthday</label>
                            </div>
    
                            @if (Auth::user()->getAccess(['patient']))
                                <div class="relative flex justify-start w-1/2 my-2">
                                    <label for="underline_select" class="sr-only">Underline select</label>
                                    <select id="underline_select" name="contact_relation" class="block py-1.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                        <option selected value="{{ strToLower($user_info->patient->contact_relation) }}">{{ $user_info->patient->contact_relation == 'extended' ? 'Extended Family' : ucwords($user_info->patient->contact_relation) }}</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="parent">Parent</option>
                                        <option value="child">Child</option>
                                        <option value="grandchild">Grandchild</option>
                                        <option value="extended">Extended Family</option>
                                    </select>
                                </div>
    
                                <div class="relative z-0 flex justify-start w-1/2 my-2">
                                    <input type="text" value="{{ $user_info->patient->emergency_contact }}" id="family_phone" name="emergency_contact" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                    <label for="emergency_contact" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Emergency Contact</label>
                                </div>
                                
                                <div class="relative z-0 flex justify-start w-1/2 my-2">
                                    <input type="password" value="" id="" name="family_code" class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                    <label for="family_code" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Family Code</label>
                                </div>
    
                            @endif
                        </div>
                        
                        <div class="flex justify-center">
                            <input type="submit" value="Edit Information" class="cursor-pointer text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        </div>
                    </form>
                </div>
            </div>



            {{-- Bottom Right --}}
            <div class="bg-gray-200 p-4 pt-2 rounded-lg shadow-gray-600 shadow-md flex-grow">
                @if (Auth::user()->getAccess(['patient']))
                    {{-- TODAYS LOG FOR PATIENT --}}
                    @include('components.profile.patientDaily')

                @elseif (Auth::user()->getAccess(['supervisor', 'admin']))
                    {{-- ALL APTS TODAY --}}
                    @include('components.profile.todaysAppointments')
                                    
                @elseif (Auth::user()->getAccess(['doctor']))
                    {{-- DOCTORS APTS SPECIFIC TO DOCTOR --}}
                    @include('components.profile.doctorDaily')

                @elseif (Auth::user()->getAccess(['caregiver']))
                    {{-- CAREGIVERS PATIENTS FOR TODAY --}}
                    @include('components.profile.caregiverDaily')

                @elseif (Auth::user()->getAccess(['family']))
                    {{-- SEARCH FOR FAMILY MEMBER WITH FAMILY CODE --}}
                    @include('components.profile.familyConnect')
                @endif
            </div>
        </div>
    </div>

{{-- </div> --}}




{{-- DELETE USER MODAL --}}    
    <div id="delete-user-modal" aria-hidden="true" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-user-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to <span class="font-bold text-red-500">DELETE</span> your account?</h3>
                    <div class="flex items-center justify-center">
                        <form action="{{ route('users.destroy',['user' => Auth::id()]) }}" method="post" class="">
                            @csrf
                            @method("delete")
                            <input type="submit" value="Delete" data-modal-toggle="delete-user-modal" data-modal-hide="delete-user-modal" class="cursor-pointer text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        </form>
                        <button data-modal-toggle="delete-user-modal" data-modal-hide="delete-user-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{-- EDIT PROF PIC MODAL --}}


<!-- Modal toggle -->

  
  <!-- Main modal -->
    <div id="edit-pic-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update Profile Picture
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-pic-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form action="{{ route('edit.profile.pic', ['user' => Auth::id()]) }}" method="post" enctype="multipart/form-data" class="flex flex-col items-center justify-center">
                        @csrf
                        <input name="profile_pic" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                        <button type="submit" class="cursor-pointer w-fit hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
  
    
@endsection

@section('script')
    <script src="{{ asset('js/profile/profile.js') }}"></script>
@endsection
