@extends('layouts.app')
@section('title', 'All Patients')

@section('mainContent')
<div class="mx-auto min-h-full mt-1">
    {{-- TODO this will the wrapper for the search attributes adjust widths once have all the inputs in --}}
    <div class="flex">
        <select id="columnName" class=" block p-2.5 z-20 text-sm border-s-2 border border-s-gray-700 border-blue-700 placeholder-gray-40  rounded-s-lg">
            <option value="id">Id</option>
            <option value="name">Name</option>
            <option value="age">Age</option>
            <option value="emergency_contact">Emergency Contact</option>
            <option value="contact_relation">Contact Relation</option>
            <option value="id">Id</option>
        </select>
    </div>
</div>
@endsection



@section('navLink')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{asset('js/employees/employees-index.js')}}"></script>
@endsection