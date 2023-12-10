@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@section('title', 'Admin Report')

@section('mainContent')
<div class="mx-auto min-h-full mt-1">
    <div class="flex justify-center mb-1">
            <p class="flex items-center text-xl font-semibold text-gray-500 dark:text-gray-400">Missed Patient Activity <button data-popover-target="popover-top" data-popover-placement="top" type="button"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Additional Info</span></button></p>
            <div data-popover id="popover-top" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Additional Info</h3>
                </div>
                <div class="px-3 py-2">
                    <p class="border-b">(-) Means the appointment/log was completed for the date or there was no appointment/log for that date</p>
                    <p class="border-b">(&#10003;) Means the task was completed</p>
                    <p class="border-b">(&#x2715;) Means the task was not completed</p>
                </div>
                <div data-popper-arrow></div>
            </div>
    </div>
    <div class="flex justify-center">
        <div class="flex relative max-w-sm">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                </svg>
            </div>
            <input id="datePicker" required name="date" datepicker datepicker-autohide type="text" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer" placeholder="Select date">
            <button id="clear" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Clear</button>
        </div>
    </div>
    <div class="pb-20">
        <table id="myTable" class="text-base sm:text-sm">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Date</th>
                    <th>Doctor ID</th>
                    <th>Attended</th>
                    <th>Caregiver ID</th>
                    <th>Morning Med</th>
                    <th>Afternoon Med</th>
                    <th>Night Med</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                </tr>
            </thead>
            <tbody class="text-center w-full">
                @foreach ($patientData as $patientId => $dates)
                    @foreach ($dates as $date => $data)
                    @php
                        $log = optional($data['log']);
                        $appointment = optional($data['appointment']);
                    @endphp
                        <tr>
                            <td>{{ $patientId }}</td>
                            <td>{{ $date ? \Carbon\Carbon::parse($date)->format('m-d-y') : '-' }}</td>
                            <td>{{ $appointment->exists ? $appointment->doctor_id : '-' }}</td>
                            <td>
                                @if($appointment->exists)
                                    &#x2715;
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $log->exists ? $log->caregiver_id : '-' }}</td>
                            <td>{!! $log->exists ? ($log->morning_med ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                            <td>{!! $log->exists ? ($log->afternoon_med ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                            <td>{!! $log->exists ? ($log->night_med ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                            <td>{!! $log->exists ? ($log->breakfast ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                            <td>{!! $log->exists ? ($log->lunch ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                            <td>{!! $log->exists ? ($log->dinner ? '&#10003;' : '&#x2715;') : '-' !!}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>    
        </table>
    </div>
</div>
@endsection



@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="{{asset('js/admin/admin-reports.js')}}"></script>
@endsection