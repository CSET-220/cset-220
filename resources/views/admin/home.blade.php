@extends('layouts.app')

@section('title')
    Admin Home
@endsection

@section('navLink')
<nav>
    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-blue-700 rounded-lg bg-gray-700 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-8 md:bg-blue-700 dark:bg-gray-700 md:dark:bg-gray-700">
        <li>
            <a href="{{ route('admin.show', ['admin' => Auth::id()]) }}">Home</a>        
        </li>
        <li>
            <a href="{{ route('admin.index') }}">Account Approval</a>
        </li>
        <li>
            <a href="{{ route('roles.index') }}">Role Creation</a>
        </li>
    </ul>
</nav>
@endsection

@section('pageHeader')
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-10 w-full">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Admin Home</h1>
        </div>
    </div>
@endsection

@section('mainContent')

@endsection

