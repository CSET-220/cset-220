@extends('layouts.app')

@section('title')
    Wrinkly Ranch - Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
@endsection

@section('pageHeader')
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Appointments</h1>

            {{-- @if (session('appointment_success'))
                <p class="text-lg text-green-500">{{ session('appointment_success') }}</p>
            @endif --}}
        </div>
    </div>
    {{--  --}}
@endsection



@section('mainContent')
    <section class="flex flex-col flex-grow p-3 sm:p-5">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            {{-- TABLE START --}}
            <table id="appointments_table" class="bg-gray-300 w-full text-sm text-left rtl:text-right text-gray-400">

                {{-- CAPTION --}}
                <caption id="" class="p-5 text-lg font-semibold text-left rtl:text-right text-white bg-gray-800">
                    <p id="table_caption" class="text-lg font-semibold text-left rtl:text-right text-white bg-gray-800">Schedule Appointment</p>
                    @error('patient_id')
                        <p class="mt-1 text-sm font-normal text-red-500">{{ $errors->first('patient_id') }}</p>
                    @enderror
                    @error('apt_date')
                        <p class="mt-1 text-sm font-normal text-red-500">{{ $errors->first('apt_date') }}</p>
                    @enderror
                    @error('doctor_id')
                        <p class="mt-1 text-sm font-normal text-red-500">{{ $errors->first('doctor_id') }}</p>
                    @enderror

                    <p id="sub_caption"></p>
                    <p id="table_sub_caption" class="mt-1 text-sm font-normal text-green-500">
                        @if(session('appointment_change_success'))
                            {{ session('appointment_change_success') }}
                        @elseif(session('appointment_success'))
                            {{ session('appointment_success') }}
                        @endif
                    </p>
                </caption>

                {{-- NEW APPOINTMENT FORM --}}
                <form action="{{ route('appointments.store') }}" method="post">
                    @csrf
                    <thead class=" border-b bg-gray-600 border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap text-white">
                            <label for="patient_id" class="sr-only">Underline select</label>
                            <select id="patient_id" name="patient_id" class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-gray-800 border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer @error('patient_id') border-red-500 @enderror"required>
                                <option value="">New Appointment</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user->full_name }}</option>
                                @endforeach
                            </select>
                        </th>

                        <td class="px-6 py-4">    
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide datepicker-format="yyyy/mm/dd" type="text" id="apt_date" name="apt_date" class=" border text-sm rounded-lg  block w-full ps-10 p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 @error('apt_date') border-red-500 @enderror" placeholder="Select date"required>
                            </div>
                        </td>
                        <td colspan="" class="px-6 py-4">
                            <label for="doctor_id" class="sr-only">Doctor</label>
                            <select id="doctor_id" name="doctor_id" class="doctor_dropdown block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-gray-400 border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer @error('doctor_id') border-red-500 @enderror"required>
                                <option hidden>Choose Doctor</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <input type="submit" value="Schedule" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200 shadow">
                        </td>
                    </thead>
                </form>
                <thead class="text-xs uppercase bg-gray-600 text-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Patient name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th colspan="2" scope="col" class="px-6 py-3 border-0">
                            Doctor
                        </th>
                    </tr>
                </thead>
                <tbody id="appointment_body">
                    {{-- FILLED W/ JS --}}
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" class="border-0 p-0 h-16">
                            <div class="grid grid-cols-2 gap-4 h-full">
                                <div id="previousPageButton" class="cursor-pointer text-gray-800 hover:bg-gray-700 hover:text-white h-full flex items-center justify-center">
                                    <p class="text-center">Previous</p>
                                </div>
                                <div id="nextPageButton" class="cursor-pointer text-right text-gray-800 hover:bg-gray-700 hover:text-white h-full flex items-center justify-center">
                                    <p class="text-center">Next</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>


            </table>
        </div>
    </section>

    
@endsection

@section('script')
    <script src="{{ asset('js/appointments/appointments.js') }}"></script>
@endsection