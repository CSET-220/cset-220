@extends('layouts.app')

@section('title')
    Account Approval
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
            <h1 class="text-4xl font-bold mb-4">Role Creation</h1>
        </div>
    </div>
@endsection

@section('mainContent')
    

<div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Access Level
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$role->role_title}}
                        </th>
                        <td class="px-6 py-4">
                            {{$role->access_level}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="{{route('roles.store')}}" class="max-w-sm mx-auto flex items-center">
        <div class="mb-5">
            <label for="role_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
            <input type="text" name="role_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="mb-5">
            <label for="access_level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Access Level</label>
            <input type="text" name="access_level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
    </form>
@endsection