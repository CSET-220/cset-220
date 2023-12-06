@extends('layouts.app')

@section('title', 'Patient Home')

@section('mainContent')

    <div class="ml-4">
        <div class="mt-4 mb-10">
            <h1 class="text-3xl mb-2">Welcome, {{ $user->first_name }} {{ $user->last_name }}</h1>
            <p class="text-xl">Patient ID: {{ $patient->id }}</p>
        </div>
        <div class="flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4">Daily Log</h2>

            <div>
                <div class="flex justify-between">
                    <div class="flex gap-4 relative max-w-sm mb-4">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input inline-datepicker datepicker-buttons datepicker-format="yyyy-mm-dd" type="text" id="date-picker" class="date-picker">
                        <button id="clear" class="date-picker-btn">Clear</button>
                    </div>
                    <div>
                        <button class="date-picker-btn">
                            <a href="{{ route('patients.logs', ['id' => auth()->user()->patient]) }}">View all logs</a>
                        </button>
                    </div>
                </div>
            
                @if ($log)
                    <table id="myTable" class="table-layout">
                        <thead class="border border-slate-500">
                            <tr>
                                <th>Doctor</th>
                                <th>Appointment</th>
                                <th>Caregiver</th>
                                <th>Morning Meds</th>
                                <th>Afternoon Meds</th>
                                <th>Night Meds</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                            </tr>
                        </thead>
                        <tbody class="patient-table border border-slate-500">
                            <tr id="patient-log-row">
                                <td>{{ $appointment ? $appointment->doctor->first_name . " " . $appointment->doctor->last_name : 'N/A' }}</td>
                                <td>{{ $appointment ? ($appointment->comments ? '✓' : '') : 'N/A' }}</td>
                                <td>{{ $log->caregiver->first_name }} {{ $log->caregiver->last_name }}</td>
                                <td>{{ $log->morning_med ? '✓' : '' }}</td>
                                <td>{{ $log->afternoon_med ? '✓' : '' }}</td>
                                <td>{{ $log->night_med ? '✓' : '' }}</td>
                                <td>{{ $log->breakfast ? '✓' : '' }}</td>
                                <td>{{ $log->lunch ? '✓' : '' }}</td>
                                <td>{{ $log->dinner ? '✓' : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <h3>There are no logs for this day</h3>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        // global variable to be used in patients-show.js
        let patientId = "{{ $patient->id }}";
    </script>
    <script src="{{ asset('js/patients/patients-show.js') }}"></script>

@endsection
