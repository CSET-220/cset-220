@section('linkStyles')

    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/b-2.4.2/b-html5-2.4.2/cr-1.7.0/date-1.5.1/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
    <style>
        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: end;
        }
    </style>

@endsection

<div class="flex flex-col justify-center items-center mt-4">
    <div class="mb-4">
        <h1 class="text-3xl font-semibold">All Logs</h1>
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

        <tbody class="border border-slate-500">
            @forelse ($patient->logs as $log)
                @php
                    $appointment = $patient->appointments->firstWhere('date', $log->date);
                @endphp
                <tr id="patient-log-row">
                    <td>{{ date('m-d-Y', strtotime($log->date)) }}</td>
                    <td>
                        {{ $appointment ? $appointment->doctor->first_name . " " . $appointment->doctor->last_name : 'N/A' }}
                    </td>
                    <td>
                        {!! $appointment ? ($appointment->comments ? 'X' : '-') : 'N/A'  !!}
                    </td>
                    <td>{{  $log->caregiver->first_name  }} {{ $log->caregiver->last_name }}</td>
                    <td>{!! $log->morning_med ? 'X' : '-' !!}</td>
                    <td>{!! $log->afternoon_med ? 'X' : '-' !!}</td>
                    <td>{!! $log->night_med ? 'X' : '-' !!}</td>
                    <td>{!! $log->breakfast ? 'X' : '-' !!}</td>
                    <td>{!! $log->lunch ? 'X' : '-' !!}</td>
                    <td>{!! $log->dinner ? 'X' : '-' !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">There are no logs available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TODO: Fix issue with table displaying behind footer so this div can be removed --}}
    <div class="w-full h-20 mt-10"></div>
</div>

@section('script')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/b-2.4.2/b-html5-2.4.2/cr-1.7.0/date-1.5.1/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>
    
    <script>
        let filename = "{{ $patient->user->first_name }} {{ $patient->user->last_name }} - Daily Logs";
    </script>
    <script src="{{ asset('js/patients/patient-logs.js') }}"></script>

@endsection