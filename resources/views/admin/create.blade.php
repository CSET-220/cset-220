@extends('layouts.app')
@section('title', 'Employee List')

{{-- TODO add refresh button to set data back to original state or something --}}

@section('mainContent')
<div class="flex-col min-h-screen pb-20 my-2">
    <div class="mx-10">
        @if($employees)
        <div class="flex w-full">
            <select id="columnName" class="w-1/5 block p-2.5 z-20 text-sm border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white focus:border-blue-500 rounded-s-lg">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="role_title">Role</option>
                <option value="salary">Salary</option>
            </select>
            <input type="search" id="searchInput" class="search-field flex-grow p-2.5 text-sm border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700  border-gray-600 placeholder-gray-400 text-white focus:border-blue-500" placeholder="Search...">         
            <input type="number" id="minSalary" class="salary-field flex-grow p-2.5 text-sm  border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700  border-gray-600 placeholder-gray-400 text-white focus:border-blue-500" placeholder="Minimum Salary">
            <input type="number" id="maxSalary" class="salary-field flex-grow p-2.5 text-sm  border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700  border-gray-600 placeholder-gray-400 text-white focus:border-blue-500" placeholder="Maximum Salary">
            <input type="text" id="first_name" class="name-field flex-grow p-2.5 text-sm  border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700  border-gray-600 placeholder-gray-400 text-white focus:border-blue-500" placeholder="First Name">
            <input type="text" id="last_name" class="name-field flex-grow p-2.5 text-sm  border-s-2 border focus:ring-blue-500 bg-gray-700 border-s-gray-700  border-gray-600 placeholder-gray-400 text-white focus:border-blue-500" placeholder="Last Name">
            <div class="relative">
                <button type="" id="searchSubmit" class="p-2.5 text-sm font-medium h-full text-white rounded-e-lg border border-blue-700 focus:ring-4 focus:outline-none bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
        <table class="divide-y divide-gray-200 w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-1/4 px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                </tr>
            </thead>
            <tbody id="tBody" class="bg-white divide-y divide-gray-200">
                <tr>
                </tr>
                @foreach ($employees as $employee)
                <tr>
                    <td class="px-3 py-2 text-center align-middle">{{$employee->id}}</td>
                    <td class="px-3 py-2 text-center align-middle">{{$employee->user->first_name}} {{$employee->user->last_name}}</td>
                    <td class="px-3 py-2 text-center align-middle">{{ucfirst($employee->user->role->role_title)}}</td>
                    <td class="px-3 py-2 text-center align-middle">
                        <div class="flex min-w-full justify-center items-center">
                            <div class="flex-1"></div>
                            <span id="salary-{{$employee->id}}" class="flex-1 text-center">{{$employee->salary}}</span>
                            <svg id="{{$employee}}" data-employee-id="{{$employee->id}}" class="w-6 h-6 text-gray-800 dark:text-white cursor-pointer flex-1 right-0 employee-svg" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                            </svg>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="flex justify-center align-middle mt-2">
            <p class="text-2xl font-semibold">No Employees available</p>
        </div>
        @endif
    </div>
</div>
<dialog id="dialog" class="">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 w-full">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Update Employee Salary
                </h3>
                <button type="button" id="closeDialog" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg id="closeDialog" class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="employeeId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee ID</label>
                        <input type="number" name="employeeId" id="employeeId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="" readonly>
                    </div>
                    <div class="col-span-2">
                        <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary</label>
                        <input type="number" name="salary" id="salary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type Salary Amount" required="">
                    </div>
                </div>
                @auth
                @if(auth()->user()->getAccess(['admin']))
                <button id="updateSalary" type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
                @else
                <button id="updateSalary" type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:cursor-not-allowed disabled:bg-gray-300" disabled>
                    Submit
                </button>
                @endif
                @endauth
            </form>
        </div>
    </div>
</dialog>
@endsection



@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{asset('js/admin/admin-create.js')}}"></script>
@endsection