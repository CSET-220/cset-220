@extends('layouts.app')
@section('title', 'Employee List')

@section('mainContent')
{{-- <img class="absolute left-1 top-20" src="https://media0.giphy.com/media/OFhB9mzG1hACQ/giphy.gif" alt=""> --}}
<div class="flex-col mx-auto min-h-screen pb-20 my-2 w-1/2">
    <div class="mx-10">
        @if($employees)
        <div class="flex w-full">
            <select id="columnName" class="block p-2.5 z-20 text-sm border-s-2 border bg-gray-800 text-gray-400 border-s-gray-700 border-blue-700 placeholder-gray-40  rounded-s-lg">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="role_title">Role</option>
                <option value="salary">Salary</option>
            </select>
            <input type="search" id="searchInput" class="flex-grow p-2.5 text-sm border-s-2 border bg-gray-800 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Search...">         
            <input type="number" id="minSalary" class="flex-grow p-2.5 text-sm border-s-2 border bg-gray-800 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Minimum Salary">
            <input type="number" id="maxSalary" class="flex-grow p-2.5 text-sm border-s-2 border bg-gray-800 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Maximum Salary">
            <input type="text" id="first_name" class="flex-grow p-2.5 text-sm border-s-2 border bg-gray-800 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="First Name">
            <input type="text" id="last_name" class="flex-grow p-2.5 text-sm border-s-2 border bg-gray-800 border-s-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Last Name">
            <div class="relative">
                <button  id="searchSubmit" class="p-2.5 text-sm font-medium h-full text-white border border-blue-700 bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4" id="employee-refresh" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
            <div class="relative">
                <button class="p-2.5 text-sm font-medium h-full rounded-e-lg border border-blue-700 bg-gray-800">
                    <svg id="refresh-svg" xmlns="http://www.w3.org/2000/svg" x="2px" y="2px" width="25" height="25" viewBox="0 0 30 30">
                        <path d="M 15 3 C 12.053086 3 9.3294211 4.0897803 7.2558594 5.8359375 A 1.0001 1.0001 0 1 0 8.5449219 7.3652344 C 10.27136 5.9113916 12.546914 5 15 5 C 20.226608 5 24.456683 8.9136179 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.441216 7.8348596 21.297943 3 15 3 z M 4.3007812 9 L 0.30078125 15 L 3 15 C 3 21.635519 8.3644809 27 15 27 C 17.946914 27 20.670579 25.91022 22.744141 24.164062 A 1.0001 1.0001 0 1 0 21.455078 22.634766 C 19.72864 24.088608 17.453086 25 15 25 C 9.4355191 25 5 20.564481 5 15 L 8.3007812 15 L 4.3007812 9 z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <table class="divide-y divide-gray-200 w-full text-gray-900">
            <thead class="bg-gray-800 text-gray-400">
                <tr>
                    <th scope="col" class="w-1/4 px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="w-1/4 px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                </tr>
            </thead>
            <tbody id="tBody" class="bg-gray-400 divide-y divide-gray-200">
                @foreach ($employees as $employee)
                <tr class="hover:text-white hover:bg-gray-800">
                    <td class="px-3 py-2 text-left align-middle border !border-gray-900">{{$employee->id}}</td>
                    <td class="px-3 py-2 text-left align-middle border !border-gray-900">{{$employee->user->first_name}} {{$employee->user->last_name}}</td>
                    <td class="px-3 py-2 text-left align-middle border !border-gray-900">{{ucfirst($employee->user->role->role_title)}}</td>
                    <td class="px-3 py-2 text-left align-middle border !border-gray-900">
                        <div class="flex min-w-full justify-center items-center">
                            <span id="salary-{{$employee->id}}" class="flex-grow text-left">{{$employee->salary}}</span>
                            <svg id="{{$employee}}" data-employee-id="{{$employee->id}}" class="w-5 h-5 text-gray-900 dark:text-white cursor-pointer  right-0 employee-svg flex-end" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
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
<dialog id="dialog" class="w-1/4">
    <div class="relative p-4 w-full max-h-full">
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
            <div class="flex items-center justify-center border-b dark:border-gray-600">
                <p id="salary-error" class="text-red-500 text-lg hidden text-center h-3"></p>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5 w-full">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="employeeId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee ID</label>
                        <input type="number" name="employeeId" id="employeeId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required readonly>
                    </div>
                    <div class="col-span-2">
                        <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary</label>
                        <input type="number" name="salary" id="salary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type Salary Amount" required>
                    </div>
                </div>
                @auth
                @if(auth()->user()->getAccess(['admin']))
                <button id="updateSalary" type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
                @else
                <button id="updateSalary" type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:cursor-not-allowed disabled:bg-gray-300" disabled data-popover-target="disabledSalary">
                    Submit
                </button>
                <div data-popover id="disabledSalary" class="invisible w-full bg-red-200 text-red-700 p-3 rounded-lg shadow-lg">
                    <p>You do not have access to this feature</p>
                </div>
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