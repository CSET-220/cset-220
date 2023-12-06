@extends('layouts.app')

@section('title', 'Patient Logs')

@section('mainContent')

<div class="flex flex-col justify-center items-center mt-4">
    <div class="mb-4">
        <h1 class="text-3xl">All Logs</h1>
    </div>
    <table id="myTable" class="table-layout">
        <thead class="border border-slate-500">
            <tr>
                <th>Date</th>
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
            @forelse ($patient->logs as $log)
                @php
                    $appointment = $patient->appointments->firstWhere('date', $log->date);
                @endphp
                <tr id="patient-log-row">
                    <td>{{ date('m/d/y', strtotime($log->date)) }}</td>
                    <td>
                        {{ $appointment ? $appointment->doctor->first_name . " " . $appointment->doctor->last_name : 'N/A' }}
                    </td>
                    <td>
                        {{ $appointment ? ($appointment->comments ? '✓' : '') : 'N/A'  }}
                    </td>
                    <td>{{ $log->caregiver->first_name }} {{ $log->caregiver->last_name }}</td>
                    <td>{{ $log->morning_med ? '✓' : '' }}</td>
                    <td>{{ $log->afternoon_med ? '✓' : '' }}</td>
                    <td>{{ $log->night_med ? '✓' : '' }}</td>
                    <td>{{ $log->breakfast ? '✓' : '' }}</td>
                    <td>{{ $log->lunch ? '✓' : '' }}</td>
                    <td>{{ $log->dinner ? '✓' : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">There are no logs available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="w-full h-20 mt-10"></div>
</div>

@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script src="{{ asset('js/patients/patients-logs.js') }}"></script>
@endsection