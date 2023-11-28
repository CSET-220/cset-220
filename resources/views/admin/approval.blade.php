@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
            <h1 class="text-4xl font-bold mb-4">Account Approval</h1>
        </div>
    </div>
@endsection

@section('mainContent')
    <div class="relative overflow-x-auto">
        <table id="myTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Approve
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Deny
                    </th>
                </tr>
            </thead>
            <tbody>
                <form action="{{route('admin.approval')}}" method="post">  
                    @csrf
                    @foreach($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$user->first_name}} {{$user->last_name}}
                        </th>
                        <td class="px-6 py-4">
                            {{App\Models\Role::where('id',$user->role_id)->value('role_title')}}
                        </td>
                        <td class="px-6 py-4">
                            <input type="checkbox" name="approve[]" value="{{$user->id}}">
                        </td>
                        <td class="px-6 py-4">
                            <input type="checkbox" name="deny[]" value="{{$user->id}}">
                        </td>
                    </tr>
                    @endforeach
                    <input type="submit" value="Submit">
                </form>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection