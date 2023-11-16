@extends('layouts.app')

@section('title', 'Patient Home')

@section('mainContent')

    <div class="ml-4">
        <div class="mt-4 mb-10">
            <h1 class="text-3xl mb-2">Welcome, </h1>{{-- $user->name --}}
            <p class="text-xl">Patient ID: </p>{{-- $patient->id --}}
        </div>
        <div>
            <h2 class="text-xl font-bold mb-4">Daily Log</h2>

            <div class="relative max-w-sm mb-4">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
            </div>

            <table class="table-layout border-collapse border">
                <thead class="border border-slate-500">
                    <tr>
                        <th>Doctor</th>
                        <th>Appointment</th>
                        <th>Caregiver</th>
                        <th>Morning Medication</th>
                        <th>Afternoon Medication</th>
                        <th>Night Medication</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                    </tr>
                </thead>
                <tbody class="border border-slate-500">
                    <tr>
                        <td>tom{{-- if appointment ? doctor name : "" --}}</td>
                        <td>{{-- if appointment ? attended (boolean) : "" --}}</td>
                        <td>{{-- caregiver name --}}</td>
                        <td>{{-- morning med --}}</td>
                        <td>{{-- afternoon med --}}</td>
                        <td>{{-- night med --}}</td>
                        <td>{{-- breakfast --}}</td>
                        <td>{{-- lunch --}}</td>
                        <td>{{-- dinner --}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
