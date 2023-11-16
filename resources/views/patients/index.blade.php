@extends('layouts.app')

@section('title', 'Patient Home')

@section('mainContent')

    <div>
        <div class="">
            <h1>Welcome, {{-- $user->name --}}</h1>
            <p>Patient ID: {{-- $patient->id --}}</p>
        </div>
        <div>
            <h2>Daily Log</h2>
            <div></div> {{-- TODO: Datepicker component --}}

            <table class="table-layout">
                <thead>
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
                <tbody>
                    <tr>tom{{-- if appointment ? doctor name : "" --}}</tr>
                    <tr>{{-- if appointment ? attended (boolean) : "" --}}</tr>
                    <tr>{{-- caregiver name --}}</tr>
                    <tr>{{-- morning med --}}</tr>
                    <tr>{{-- afternoon med --}}</tr>
                    <tr>{{-- night med --}}</tr>
                    <tr>{{-- breakfast --}}</tr>
                    <tr>{{-- lunch --}}</tr>
                    <tr>{{-- dinner --}}</tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
