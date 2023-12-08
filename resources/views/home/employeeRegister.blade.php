@extends('layouts.app')


@section('title')
    Wrinkly Ranch - Join our Team
@endsection

{{-- @section('navLink')
    
@endsection --}}

@section('pageHeader')
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Join the Wrinkly Team</h1>
            <p class="text-lg">Positions Available</p>
        </div>
    </div>
    {{--  --}}
@endsection

@section('mainContent')
@include('home.loginModal')
    <div class="flex flex-col mb-16 relative flex-grow">
        {{-- Register --}}
            <div id="register" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-center">Do you Have What It Takes?</h2>
                <div class=" w-1/2 mx-auto">
                    <form action="{{ route('users.store') }}" method="post" class="p-8 rounded-lg shadow-lg bg-gray-200">
                        @csrf
                        {{-- EMAIL --}}
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="email" value="{{ old('email') }}" name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('email') focus:border-red-500 peer @enderror" placeholder=" " required />
                            <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email')  peer-focus:text-red-500  @enderror">Email address</label>
                            @error('email')
                                <p class="text-xs text-red-500">{{ $errors->first('email') }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('password') focus:border-red-500 peer @enderror" placeholder=" " required />
                            <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password')  peer-focus:text-red-500  @enderror">Password</label>
                            @error('password')
                                <p class="text-xs text-red-500">{{ $errors->first('password') }}</p>
                            @enderror
                            <ul class="hidden password_requirements max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                <h2 class="mb-2 font-semibold text-gray-900 dark:text-white">Password requirements:</h2>
                                <li class="flex items-center text-sm length_req">
                                    <svg class="length_req w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    At least 8 characters
                                </li>
    
                                <li class="flex items-center text-sm number_req">
                                    <svg class="number_req w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    At least one NUMBER
                                </li>
    
                                <li class="flex items-center text-sm lower_req">
                                    <svg class="lower_req w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    At least one LOWERCASE character
                                </li>
                                
                                <li class="flex items-center text-sm upper_req">
                                    <svg class="upper_req w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    At least one UPPERCASE character
                                </li>
    
                                <li class="flex items-center text-sm special_req">
                                    <svg class="special_req w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    At least one SPECIAL character, e.g., ! @ # ?
                                </li>
                            </ul>
                        </div>

                        {{-- FIRST NAME --}}
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" value="{{ old('first_name') }}" name="first_name" id="first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('first_name') focus:border-red-500 peer @enderror" placeholder=" " required />
                                <label for="first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('first_name')  peer-focus:text-red-500  @enderror">First name</label>
                                @error('first_name')
                                    <p class="text-xs text-red-500">{{ $errors->first('first_name') }}</p>
                                @enderror
                            </div>

                            {{-- LAST NAME --}}
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" value="{{ old('last_name') }}" name="last_name" id="last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('last_name') focus:border-red-500 peer @enderror" placeholder=" " required />
                                <label for="last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('last_name')  peer-focus:text-red-500  @enderror">Last name</label>
                                @error('last_name')
                                    <p class="text-xs text-red-500">{{ $errors->first('last_name') }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="grid md:grid-cols-2 md:gap-6">
                            {{-- PHONE NUMBER --}}
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="tel" name="phone"  value="{{ old('phone') }}" id="phone_number" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('phone') focus:border-red-500 peer @enderror" placeholder=" " required />
                                <label for="phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('phone')  peer-focus:text-red-500  @enderror">Phone number</label>
                                @error('phone')
                                    <p class="text-xs text-red-500">{{ $errors->first('phone') }}</p>
                                @enderror
                            </div>

                            {{-- DATE OF BIRTH --}}
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input value="{{ old('date_of_birth') }}" datepicker datepicker-autohide datepicker-buttons datepicker-format="yyyy/mm/dd" type="text" name="date_of_birth" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date of Birth">
                                    @error('date_of_birth')
                                        <p class="text-xs text-red-500">{{ $errors->first('date_of_birth') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- USER TYPE --}}
                        <div class="relative">
                            <label for="user_type" class="sr-only">Positions Available</label>
                            <select id="" name="user_type" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option hidden>Positions Available</option>
                                <option value="supervisor" @if (old('user_type') == "supervisor") {{ 'selected' }} @endif>Supervisor</option>
                                <option value="doctor" @if (old('user_type') == "doctor") {{ 'selected' }} @endif>Doctor</option>
                                <option value="caregiver" @if (old('user_type') == "caregiver") {{ 'selected' }} @endif>Caregiver</option>
                                
                            </select>
                            @error('user_type')
                                <p class="text-xs text-red-500">{{ $errors->first('user_type') }}</p>
                            @enderror
                        </div>

                        {{-- Submit--}}
                        <div class="flex justify-center mt-8">
                            <input type="submit" value="Apply Now" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        </div>
                    </form>
                </div>
            </div>
        {{--  --}}
    </div>
    
@endsection


@section('script')
    <script src="{{ asset('js/homepage.js') }}"></script>

    <script>
    
        jQuery(document).ready(function () {
            @if ($errors->has('login_email'))
                jQuery(function($){ $("#login-modal").removeClass('hidden'); }) 
            @endif
        });
    </script>

@endsection