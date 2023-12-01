@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@section('title', 'Caregiver Home')

@section('pageHeader')
<div class="mt-1 mb-1 flex flex-col items-center justify-center">
    @auth
        <h1 class="text-3xl font-semibold">Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
        <p class="text-2xl font-semibold">Today's Date: {{ \Carbon\Carbon::now()->format('m-d-Y') }}</p>
    @endauth
</div>
@endsection

@section('mainContent')
<div class="flex-col align-middle justify-center min-h-full mt-1">
    <div class="min-h-full mx-10">
        @if($patients)
        <table id="myTable" class="divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Morning Med</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Afternoon Med</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evening Med</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Breakfast</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lunch</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dinner</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($patients as $patient)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center align-middle">{{ $patient->patient_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center align-middle">{{ $patient->patient->user->first_name }} {{ $patient->patient->user->last_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center align-middle">{{ \Carbon\Carbon::parse($patient->date)->format('m-d-Y') }}</td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox"
                        {{ $patient->morning_med ? 'checked' : '' }}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="morning_med"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox" 
                        {{$patient->afternoon_med ? 'checked' : ''}}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="afternoon_med"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox" {{$patient->night_med ? 'checked' : ''}}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="night_med"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox" {{$patient->breakfast ? 'checked' : ''}}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="breakfast"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox" {{$patient->lunch ? 'checked' : ''}}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="lunch"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                    <td class="px-6 py-4 text-center align-middle">
                        <input type="checkbox" {{$patient->dinner ? 'checked' : ''}}
                        data-patient-id="{{$patient->patient_id}}"
                        data-log-type="dinner"
                        data-date="{{ \Carbon\Carbon::parse($patient->date)->format('Y-m-d') }}"
                        >
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="flex justify-center align-middle mt-2">
            <p class="text-2xl font-semibold">No patients available</p>
        </div>
        @endif
    </div>
</div>

@endsection



@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="{{asset('js/logs/logs-index.js')}}"></script>
@endsection