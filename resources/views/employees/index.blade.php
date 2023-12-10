@extends('layouts.app')
@section('title', 'All Patients')

@section('mainContent')
<div class="mx-auto min-h-full mt-5 mb-5">
    {{-- TODO this will the wrapper for the search attributes adjust widths once have all the inputs in --}}
    <div class="flex">
        <form action="{{ route('employees.patientSearch') }}" method="GET">            
            <select name="columnName" class="p-2.5 z-20 text-sm border-s-2 border border-s-gray-700 border-blue-700 placeholder-gray-40  rounded-s-lg">
                <option value="id">Patient Id</option>
                <option value="name">Name</option>
                <option value="age">Age</option>
                <option value="emergency_contact">Emergency Contact</option>
                <option value="contact_relation">Contact Relation</option>
                <option value="admission_date">Admission Date</option>
            </select>
            <input  name="searchValue" type="text">
            <button type="submit" id="searchButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-lg">Search</button>
        </form>
    </div>
</div>

<div class="relative overflow-x-auto mb-10">
    <table class="w-3/4 mx-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Patient Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Age
                </th>
                <th scope="col" class="px-6 py-3">
                    Emergency Contact
                </th>
                <th scope="col" class="px-6 py-3">
                    Contact Relation
                </th>
                <th scope="col" class="px-6 py-3">
                    Admission Date
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$patient->id}}
                </th>
                <td class="px-6 py-4">
                    {{$patient->user->first_name}} {{$patient->user->last_name}}
                </td>
                <td class="px-6 py-4">
                    {{$patient->user->age}}
                </td>
                <td class="px-6 py-4">
                    {{$patient->emergency_contact}}
                </td>
                <td class="px-6 py-4">
                    {{$patient->contact_relation}}
                </td>
                <td class="px-6 py-4">
                    {{$patient->admission_date}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-center">
        {{ $patients->links() }}
    </div>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
        }
        .pagination li {
            display: inline;
            padding: 0 5px;
        }
    </style>
</div>

@endsection



@section('navLink')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{asset('js/employees/employees-index.js')}}"></script>
@endsection