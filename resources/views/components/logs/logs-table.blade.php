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
                    <td>{{ date('m/d/y', strtotime($log->date)) }}</td>
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
        $(document).ready( () => {
            let filename = "{{ $patient->user->first_name }} {{ $patient->user->last_name }} - Daily Logs";

            $('#myTable').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'pdf',
                    text: 'Download Logs',
                    filename: `${filename}`,
                    title: 'Daily Logs',
                    customize: function (doc) {
                        doc.defaultStyle.alignment = 'center';
                    },
                }],
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
            });
        })
    </script>

@endsection