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
            <div></div> {{-- TODO: Datepicker component --}}

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
