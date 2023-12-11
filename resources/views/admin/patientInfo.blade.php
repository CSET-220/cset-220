@extends('layouts.app')

@section('title')
    Admin Home
@endsection

@section('pageHeader')
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Additional Patient Information</h1>
        </div>
    </div>
@endsection

@section('mainContent')
    @if (session('success'))
        <div class="text-center text-green-500 mt-2">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="text-center text-red-500 mt-2">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" action="{{route('admin.updatePatientInfo')}}" class="w-1/4 mx-auto mb-20 relative p-4 overflow-x-auto">
        @csrf
        <input type="text" name="patient_id" id="patient_id" class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <input readonly type="text" name="patient_name" id="patient_name" class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <select name="patient_group" id="patient_group" class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <input type="date" name="admission_date" id="admission_date" value="{{ date('Y-m-d') }}" class="mb-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>    
@endsection

@section('script')
    <script src="{{ asset('js/admin/patientInfo.js') }}"></script>
@endsection 
